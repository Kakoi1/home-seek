<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Dorm;
use App\Models\Billing;
use App\Models\Notification;
use App\Models\RentForm;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Storage;
class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('home', compact('user'));
    }

    public function history()
    {
        $ownerId = auth()->id();

        // Fetch properties owned by the owner
        $ownerDorms = Dorm::where('user_id', $ownerId)->pluck('id')->toArray();

        // Fetch tenants who have completed their rental at the owner's properties
        $pastTenants = RentForm::whereIn('dorm_id', $ownerDorms)->where('status', 'completed')->with('dorm', 'user')->get();

        // Fetch bookings that are still pending for the owner's properties
        $bookings = RentForm::whereIn('dorm_id', $ownerDorms)
            ->where('status', '!=', 'pending')
            ->with('dorm', 'user')
            ->get();


        // Fetch payment history related to the owner’s properties
        $payments = Billing::whereHas('rentForm', function ($query) use ($ownerDorms) {
            $query->whereIn('dorm_id', $ownerDorms);
        })->where('status', 'paid')->with('rentForm.dorm', 'rentForm.user')->get();

        return view('owner-histo', compact('pastTenants', 'bookings', 'payments'));
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $file = $request->file('file');
        $filename = Str::random(25) . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('test-folder', $filename, 'gcs');

        return back()->with('success', 'File uploaded successfully to GCS! Path: ' . $path);
    }

    public function processPayment(Request $request, $billId)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'mode_of_payment' => 'required|in:cash,e_wallet,credit_card,bank_transfer,others',
            'payment_reference' => ($request->mode_of_payment !== 'cash') ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' : 'nullable',
            'payment_date' => 'required|date',
        ]);


        // Find the bill that corresponds to the rent form
        $paymentDate = Carbon::parse($validated['payment_date'])->setTime(now()->hour, now()->minute, now()->second);
        $bill = Billing::findOrFail($billId);
        if ($request->hasFile('payment_reference')) {
            $file = $request->file('payment_reference');
            $filename = Str::random(25) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('Proof_of_Payment', $filename, 'gcs');
            $bill->reference = $path;
        }

        $bill->mode = $validated['mode_of_payment'];
        $bill->paid_at = $paymentDate;
        $bill->status = 'paid';

        $bill->save();
        $notification = Notification::create([
            'user_id' => $bill->user_id, // Assuming the owner is linked to the room
            'type' => 'Bills',
            'data' => '<strong>Payment Reminder</strong><br><p>Your Payment has been marked paid. You paid <strong>₱' . number_format($bill->amount, 2) . '</strong> on <strong>' . $bill->rentForm->dorm->name . '</strong></p><br><p>Paid on: <strong>' . $bill->paid_at->format('Y-m-d H:i:s') . '</strong></p><p>Mode of Payment: <strong>' . $bill->mode . '</strong></p><br><p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
            'read' => false,
            'route' => route('user.rentForms'),
            'dorm_id' => $bill->rentForm->dorm_id,
            'sender_id' => Auth::id()
        ]);

        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => Auth::id(),
            'rooms' => $notification->id,
            'roomid' => $notification->dorm_id,
            'action' => 'Bills',
            'route' => route('user.rentForms')
        ]));


        // Send a success message or redirect to a success page
        return redirect()->back()
            ->with('success', 'Payment processed successfully!');
    }

    public function showUploadForm()
    {
        // Get all files in the 'test-folder' directory on GCS
        $files = Storage::disk('gcs')->files('test-folder');

        // Generate URLs for each file
        $fileUrls = array_map(function ($file) {
            return Storage::disk('gcs')->url($file);
        }, $files);

        return view('test-upload', compact('fileUrls'));
    }

}

