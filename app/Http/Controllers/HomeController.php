<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Billing;
use App\Models\RentForm;
use Illuminate\Http\Request;
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

