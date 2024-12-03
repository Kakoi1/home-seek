<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\RentForm;
use App\Models\Reports;
use App\Models\User;
use App\Models\Notification;
use App\Models\WalletTransaction;
use Crypt;
use Illuminate\Http\Request;
use App\Models\Verifications;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index()
    {
        // User Metrics
        $usersCount = User::where(function ($query) {
            $query->where('role', '!=', 'owner') // Include non-owners
                ->orWhere('verify_status', '!=', 0); // Or include owners with verify_status not 0
        })->get();
        $ownersCount = User::where('role', 'owner')->where('verify_status', 1)->get();
        $tenantsCount = User::where('role', 'tenant')->count();
        $activeUsersCount = User::where('active_status', 0)->count();
        $inactiveUsersCount = User::where('active_status', 1)->count();

        // Monthly Data for Line Graph
        $months = [];
        $activeCounts = [];
        $inactiveCounts = [];
        $tenantCounts = [];
        $ownerCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M Y');
            $activeCounts[] = User::where('active_status', 1)->whereMonth('created_at', $month->month)->count();
            $inactiveCounts[] = User::where('active_status', 0)->whereMonth('created_at', $month->month)->count();
            $tenantCounts[] = User::where('role', 'tenant')->whereMonth('created_at', $month->month)->count();
            $ownerCounts[] = User::where('role', 'owner')->whereMonth('created_at', $month->month)->count();
        }

        // Property Insights

        $totalProperties = Dorm::all();

        // Properties that are available (availability = 0) and the owner's active_status = 1
        $availableProperties = Dorm::where('availability', 0)
            ->whereHas('user', function ($query) {
                $query->where('active_status', 0);
            })
            ->count();

        // Properties that are unavailable (availability = 1) or the owner's active_status = 0
        $unavailableProperties = Dorm::where('availability', 1)
            ->orWhereHas('user', function ($query) {
                $query->where('active_status', 1);
            })
            ->count();

        // Archived properties
        $archivedProperties = Dorm::where('archive', 1)->count();

        // Flagged properties (flag = 1)
        $flaggedProperties = Dorm::where('flag', 1)->count();


        return view('admin.dashboard', compact(
            'usersCount',
            'ownersCount',
            'tenantsCount',
            'activeUsersCount',
            'inactiveUsersCount',
            'months',
            'activeCounts',
            'inactiveCounts',
            'tenantCounts',
            'ownerCounts',
            'totalProperties',
            'availableProperties',
            'unavailableProperties',
            'archivedProperties',
            'flaggedProperties'
        ));
    }


    public function manageUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        $verificationRequests = Verifications::where('status', 'pending')
            ->with('user')
            ->get();
        $req = Verifications::where('status', 'pending')->count();

        return view('admin.manageuser', compact('users', 'verificationRequests', 'req'));
    }

    public function approve($id)
    {
        // Find the verification request by ID
        $verification = Verifications::find($id);
        $user = User::find($verification->user_id);

        if ($verification) {
            // Update the status to 'approved'
            $verification->status = 'approved';
            $user->verify_status = true;
            $user->save();
            $verification->save();

            $notification = Notification::create([
                'user_id' => $verification->user_id, // Assuming the owner is linked to the room
                'type' => 'verification',
                'data' => '<strong>Account Verified</strong><br>' .
                    '<p>Your account has been verified. You can now proceed to post or list accommodations for rent.</p><br>' .
                    '<p>Sent on ' . now()->format('Y-m-d H:i:s') . '</p>',
                'read' => false,
                'route' => null,
                'dorm_id' => null,
                'sender_id' => auth::id(),
            ]);

            event(new NotificationEvent([

                'reciever' => $notification->user_id,
                'message' => $notification->data,
                'sender' => Auth::id(),
                'rooms' => $notification->id,
                'roomid' => $notification->room_id,
                'action' => 'verify',
                'route' => null
            ]));

            return response()->json(['message' => 'Verification approved successfully.']);
        } else {
            return response()->json(['message' => 'Verification not found.'], 404);
        }
    }

    public function reject(Request $request, $id)
    {
        // Find the verification request by ID
        $verification = Verifications::find($id);

        if ($verification) {
            // Update the status to 'rejected' and store the reason
            $verification->status = 'rejected';
            $verification->note = $request->input('reason'); // Assuming 'reason' is the field name
            $verification->save();

            return response()->json(['message' => 'Verification rejected successfully.']);
        } else {
            return response()->json(['message' => 'Verification not found.'], 404);
        }
    }

    public function activate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->active_status = false;
            $user->note = null;
            $user->strike = 3; // Set active status to true
            $user->save();

            return response()->json(['message' => 'User activated successfully.']);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function deactivate(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->active_status = true; // Set active status to false
            $user->note = $request->reason;
            $user->save();

            return response()->json(['message' => 'User deactivated successfully.']);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }
    public function userwarn(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Decrement the user's strike count
        if ($user->strike > 0) {
            $user->strike -= 1;
        }

        // Check if user should be deactivated
        if ($user->strike <= 0) {
            $user->active_status = true; // Deactivate user
            $user->note = $request->warnReason;
        }

        $user->save();

        // Create a notification
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => 'warning',
            'data' => "<strong>Warning issued:</strong> <br> <p>" . $request->warnReason . "</p> <br>" . "<strong>You have " . $user->strike . " remaining Strike</strong>",
            'read' => false,
            'route' => null,
            'dorm_id' => null,
            'sender_id' => Auth::id(),
        ]);

        // Trigger notification event
        event(new NotificationEvent([

            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => Auth::id(),
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'warning',
            'route' => null
        ]));

        // Return response based on user's strike count
        if ($user->strike <= 0) {
            return response()->json(['message' => 'User has been deactivated due to multiple warnings.']);
        }

        return response()->json(['message' => 'User warned successfully.']);
    }


    public function deactivateProperty(Request $request, $id)
    {
        $property = Dorm::findOrFail($id);

        if ($property->flag == false) {
            $property->flag = true;

            $notification = Notification::create([
                'user_id' => $property->user_id,
                'type' => 'warning',
                'data' => "<strong>Accomodation Deactivated</strong> <br> <p> Your Accomodation has been Deactivated due to:" . $request->reason . "</p>",
                'read' => false,
                'route' => null,
                'dorm_id' => $property->id,
                'sender_id' => Auth::id(),
            ]);

            // Trigger notification event
            event(new NotificationEvent([

                'reciever' => $notification->user_id,
                'message' => $notification->data,
                'sender' => Auth::id(),
                'rooms' => $notification->id,
                'roomid' => $notification->room_id,
                'action' => 'flag prop',
                'route' => null
            ]));
            $message = 'Property has been deactivated successfully.';
        } else {
            $property->flag = false;
            $message = 'Property has been activated successfully.';
        }
        $property->save();

        return redirect()->route('admin.manageProp')->with('success', $message);
    }

    public function manageProp()
    {
        $properties = Dorm::orderBy('created_at', 'desc')
            ->withCount('favoritedBy')  // Count of users who favorited this dorm
            ->with('reviews')           // Load related reviews for the dorm
            ->with('user')              // Load the user who owns this dorm
            ->get();

        // Add encrypted id to each property for security (e.g., for passing in URLs)
        $properties = $properties->map(function ($propertie) {
            $propertie->encrypted_id = Crypt::encrypt($propertie->id);
            return $propertie;
        });
        // dd($properties);
        return view('admin.admin-listing', compact('properties'));
    }


    public function show($id)
    {
        $dorm = Dorm::findOrFail($id);
        $dorm->encrypted_id = Crypt::encrypt($dorm->id);
        // Count total bookings
        $bookingCount = RentForm::where('dorm_id', $id)->count();

        // Count cancellations
        $cancellationCount = RentForm::where('dorm_id', $id)->where('status', 'cancelled')->count();

        // Calculate rates
        $bookingRate = $bookingCount > 0 ? ($bookingCount / $bookingCount) * 100 : 0;
        $cancellationRate = $bookingCount > 0 ? ($cancellationCount / $bookingCount) * 100 : 0;

        // Fetch tenant reviews and other data
        $reviews = $dorm->reviews()->where('rating', '>', 0)->with('user')->get();

        return response()->json([
            'dorm' => $dorm,
            'viewCount' => $dorm->views()->count(),
            'bookingCount' => $bookingCount,
            'cancellationCount' => $cancellationCount,
            'bookingRate' => $bookingRate,
            'cancellationRate' => $cancellationRate,
            'reviews' => $reviews,
        ]);
    }
    // In ReportController.php
    public function fetchReports(Request $request)
    {
        // Fetch reports with filters
        $query = Reports::with(['user', 'reported', 'dorm']);

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['pending', 'valid', 'invalid'])) {
            $query->where('status', $request->status);
        }

        // Filter by report type if provided
        if ($request->has('report_type')) {
            if ($request->report_type === 'user') {
                $query->whereNull('dorm_id');
            } elseif ($request->report_type === 'property') {
                $query->whereNotNull('dorm_id');
            }
        }

        // Paginate the results
        $reports = $query->paginate(10); // Adjust items per page as needed

        return response()->json($reports);
    }
    public function updateStatus(Request $request, $id)
    {
        $report = Reports::findOrFail($id);
        $rep_user = User::find($report->reported_id);
        $repor_user = User::find($report->user_id);

        $action = $request->input('action');

        if ($action === 'valid' || $action === 'invalid') {
            $report->status = $action === 'valid' ? 'Valid' : 'Invalid';

            if ($action === 'valid') {

                if ($report->dorm_id) {
                    $property = Dorm::find($report->dorm_id);
                    $property->flag = true;
                    $property->save();
                    $data1 = "<strong>Complaint Response:</strong> <br> <p> We have reviewed your report and have deactivated the property due to the following reason: <strong>" . $report->reason . "</strong></p>";
                    $data2 = "<strong>Action Taken on Your Property:</strong> <br> <p> Your property has been deactivated due to the following reason: <strong>" . $report->reason . "</strong></p>";

                } else {

                    if ($rep_user->strike > 0) {
                        $rep_user->strike -= 1;
                    }

                    // Check if user should be deactivated
                    if ($rep_user->strike <= 0) {
                        $rep_user->active_status = true; // Deactivate user
                        $rep_user->note = $report->reason;
                    }
                    $rep_user->save();
                    $data1 = "<strong>Complaint Review - Action Taken:</strong> <br> <p> Your report has been reviewed, and a warning has been issued to the user for the following reason: <strong>" . $report->reason . "</strong></p> <p>Please monitor the situation to ensure compliance.</p>";
                    $data2 = "<strong>Warning Notification:</strong> <br> <p> You have been issued a warning due to the following reason: <strong>" . $report->reason . "</strong></p> <p>Please take immediate action to rectify the situation. Continued violations may lead to further actions.</p> <br>" . "<strong>You have " . $rep_user->strike . " remaining Strike</strong>";
                }
                // Notification for the reporter (user who submitted the report)
                $reporterNotification = Notification::create([
                    'user_id' => $report->user_id,  // Reporter
                    'type' => 'warning',
                    'data' => $data1,
                    'read' => false,
                    'route' => null,
                    'dorm_id' => null,
                    'sender_id' => Auth::id(),
                ]);

                // Trigger notification event for the reporter
                event(new NotificationEvent([
                    'reciever' => $reporterNotification->user_id,
                    'message' => $reporterNotification->data,
                    'sender' => Auth::id(),
                    'rooms' => $reporterNotification->id,
                    'roomid' => $reporterNotification->room_id,
                    'action' => 'Report',
                    'route' => null
                ]));

                // Notification for the reported user (the user who is being reported)
                $reportedNotification = Notification::create([
                    'user_id' => $report->reported_id,  // Reported user
                    'type' => 'warning',
                    'data' => $data2,
                    'read' => false,
                    'route' => null,
                    'dorm_id' => null,
                    'sender_id' => Auth::id(),
                ]);

                // Trigger notification event for the reported user
                event(new NotificationEvent([
                    'reciever' => $reportedNotification->user_id,
                    'message' => $reportedNotification->data,
                    'sender' => Auth::id(),
                    'rooms' => $reportedNotification->id,
                    'roomid' => $reportedNotification->room_id,
                    'action' => 'Report',
                    'route' => null
                ]));
            } elseif ($action === 'invalid') {
                if ($report->dorm_id) {
                    $data1 = "<strong>Complaint Response:</strong> <br> <p> We have reviewed your report, and after careful consideration, we have determined that the complaint is invalid. The property remains active.</p>";
                } else {
                    $data1 = "<strong>Complaint Response:</strong> <br> <p> We have reviewed your complaint and, after careful consideration, we have determined that it is invalid. However, the reported user will be placed under observation for further monitoring. No immediate action has been taken, but we will continue to monitor the situation.</p>";
                }
                $reporterNotification = Notification::create([
                    'user_id' => $report->user_id,  // Reporter
                    'type' => 'warning',
                    'data' => $data1,
                    'read' => false,
                    'route' => null,
                    'dorm_id' => null,
                    'sender_id' => Auth::id(),
                ]);

                // Trigger notification event for the reporter
                event(new NotificationEvent([
                    'reciever' => $reporterNotification->user_id,
                    'message' => $reporterNotification->data,
                    'sender' => Auth::id(),
                    'rooms' => $reporterNotification->id,
                    'roomid' => $reporterNotification->room_id,
                    'action' => 'Report',
                    'route' => null
                ]));
            }


            $report->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
    public function viewCashoutRequests()
    {
        // Fetch pending cash-out requests
        $pendingRequests = WalletTransaction::where('status', 'pending')
            ->where('type', 'cash_out')
            ->get();


        return view('admin.cashout_requests', compact('pendingRequests'));
    }
    public function rejectCashout(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $cashOutRequest = WalletTransaction::findOrFail($id);
        $cashOutRequest->status = 'rejected';
        $cashOutRequest->note = $request->reason;
        $cashOutRequest->save();

        $message = "Your cash-out request of ₱" . number_format($cashOutRequest->amount, 2) . " has been rejected. Reason: " . $request->reason;

        $notification = Notification::create([
            'user_id' => $cashOutRequest->user_id,  // Receiver (requester)
            'type' => 'rejection',
            'data' => $message,
            'read' => false,
            'route' => route('cashout.page'),
            'dorm_id' => null,
            'sender_id' => Auth::id(),
        ]);

        // Trigger the notification event
        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => Auth::id(),
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'Reject',
            'route' => route('cashout.page'),
        ]));

        return redirect()->back()->with('success', 'Request rejected successfully.');
    }

    public function approveCashout($id)
    {
        $cashoutRequest = WalletTransaction::findOrFail($id);
        $cashoutRequest->update(['status' => 'completed']);

        $message = "Your cash-out request of ₱" . number_format($cashoutRequest->amount, 2) . " has been approved.";

        $notification = Notification::create([
            'user_id' => $cashoutRequest->user_id,  // Receiver (requester)
            'type' => 'approval',
            'data' => $message,
            'read' => false,
            'route' => route('cashout.page'),
            'dorm_id' => null,
            'sender_id' => Auth::id(),
        ]);

        // Trigger the notification event
        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => Auth::id(),
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'Approve',
            'route' => route('cashout.page'),
        ]));

        return redirect()->route('admin.cashout.requests')->with('success', 'Cash-out request approved.');
    }

}

