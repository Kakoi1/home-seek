<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Mail\CashInReceipt;
use App\Models\Notification;
use Mail;
use Stripe\Payout;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Http;
class WalletController extends Controller
{
    public function cashIn(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $amount = $request->amount * 100; // Convert to cents

        // Initialize Stripe
        Stripe::setApiKey(config('services.stripe.secret'));

        // Create Payment Intent
        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'php',
            'payment_method_types' => ['card'], // Accept card payments
        ]);

        // Return client secret for frontend
        return response()->json([
            'client_secret' => $paymentIntent->client_secret,
            'amount' => $request->amount,
        ]);
    }

    public function confirmCashIn(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();

        // Update Wallet Balance
        $user->wallet->balance += $request->amount;
        $user->wallet->save();

        // Record the Transaction
        $transaction = WalletTransaction::create([
            'user_id' => $user->id,
            'wallet_id' => $user->wallet->id,
            'payment_id' => $request->payment_id,  // Save the payment_id here
            'type' => 'cash_in',
            'amount' => '+' . $request->amount,
            'balance_after' => $user->wallet->balance,
            'status' => 'completed',
            'details' => 'Cash-in via Stripe',
        ]);

        $notification = Notification::create([
            'user_id' => $user->id, // Assuming the owner is linked to the room
            'type' => 'Bills',
            'data' => "<strong>Cash-In Transaction</strong><br>
                    <p>User <strong>{$user->name}</strong> has successfully added funds to their wallet.</p>
                    <p><strong>Amount:</strong> ₱" . number_format($transaction->amount, 2) . "</p>
                    <p><strong>Date:</strong> {$transaction->created_at->format('Y-m-d H:i:s')}</p>",
            'read' => false,
            'route' => null,
            'dorm_id' => null,
            'sender_id' => 14,
        ]);
        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => 14,
            'rooms' => $notification->id,
            'roomid' => null,
            'action' => 'Wallet',
            'route' => null
        ]));

        // Prepare email details
        $transactionDetails = [
            'user_name' => $user->name,
            'amount' => $transaction->amount,
            'balance_after' => $transaction->balance_after,
            'date' => $transaction->created_at->format('Y-m-d H:i:s'),
        ];

        // Send receipt email
        // Mail::to($user->email)->send(new CashInReceipt($transactionDetails));

        return response()->json(['success' => true, 'message' => 'Funds added to wallet!']);
    }



    public function getDetails()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return response()->json([
                'error' => 'Wallet not found.',
            ], 404);
        }

        return response()->json([
            'balance' => $wallet->balance,
            'transactions' => $wallet->transactions()
                ->latest() // Get the latest transactions first
                ->get() // Execute the query
                ->map(function ($transaction) {
                    return [
                        'date' => $transaction->created_at->format('Y-m-d H:i:s'),
                        'type' => ucfirst($transaction->type),
                        'amount' => number_format($transaction->amount, 2),
                    ];
                }),
        ]);
    }

    public function showCashOutPage()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        return view('cashout', [
            'walletBalance' => $wallet->balance ?? 0,
            'transactions' => $wallet->transactions()
                ->where('type', 'cash_out')
                ->latest()
                ->get()
        ]);
    }
    public function submitCashOutRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:' . auth()->user()->wallet->balance,
            'payment_method' => 'required|in:gcash,paymaya,bank_transfer',
            'account_details' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        // Deduct from wallet
        $wallet = $user->wallet;
        $wallet->balance -= $request->amount;
        $wallet->save();
        // Log transaction
        $wallet->transactions()->create([
            'type' => 'cash_out',
            'amount' => $request->amount,
            'method' => $request->payment_method,
            'details' => $request->account_details,
            'status' => 'pending', // Initial status
            'user_id' => $user->id,
            'wallet_id' => $wallet->id,
            'balance_after' => $user->wallet->balance - $request->amount,
        ]);

        return redirect()->back()->with('success', 'Cash out request submitted successfully.');
    }

}

