<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PayMongoWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        // Log the incoming webhook data for debugging
        Log::info('PayMongo Webhook:', $data);

        // Check if the payment is successful
        if ($data['data']['type'] === 'payment.paid') {
            $paymentId = $data['data']['id'];
            $amount = $data['data']['attributes']['amount'] / 100; // Convert centavos to PHP
            $userId = $data['data']['attributes']['metadata']['user_id']; // Assuming you passed user_id in metadata

            $user = User::find($userId);
            $transaction = WalletTransaction::where('payment_id', $paymentId)->first();

            if ($transaction) {
                // Update the transaction status to 'completed'
                $transaction->status = 'completed';
                $transaction->save();

                // Update wallet balance
                $user->wallet->balance += $amount;
                $user->wallet->save();

                // Store a success message in session
                session()->flash('success', 'Payment successfully processed. Your wallet has been updated.');

                return response('Webhook Handled', 200); // Acknowledge the webhook
            }
        }

        return response('Webhook Not Handled', 400);
    }

}

