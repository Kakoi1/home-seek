<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use DB;
use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\Room;
use App\Models\User;
use App\Models\Billing;
use App\Models\Chatroom;
use App\Models\RentForm;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ExtendRequest;
use App\Models\Verifications;
use Illuminate\Validation\Rule;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\SendVerificationCodeMail;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function callbackFromFacebook()
    {
        try {
            // Fetch the Facebook user data
            $facebookUser = Socialite::driver('facebook')->user();

            // Check if the user exists in the database by Facebook ID
            $user = User::where('fb_id', $facebookUser->getId())->first();

            if (!$user) {
                // If the user does not exist, create a user without an email/phone yet
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'fb_id' => $facebookUser->getId(),
                    'profile_picture' => $facebookUser->getAvatar(),
                ]);
                return view('emails.collect_email_phone', ['user' => $user])->with('success', 'Provide gmail and Phone no. to login');
            } else {
                // If the user exists, simply log them in and redirect to home
                if (!$user->email) {
                    return view('emails.collect_email_phone', ['user' => $user])->with('success', 'Provide gmail and Phone no. to login');
                } else if ($user->email_verified_at == null) {
                    return redirect()->route('send.email', $user)->withErrors(['logname' => 'Please verify your email to continue.']);
                } else {
                    Auth::login($user);
                    return redirect('/home');
                }
            }

        } catch (\Exception $e) {
            // Handle errors
            return redirect('/login');
        }
    }


    public function collectEmailPhone(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone_number' => 'required',
        ]);

        // Find the user by ID
        $user = User::find($request->user_id);

        if ($user) {
            // Update the user with the email and phone number
            if ($user->email) {
                $verificationCode = rand(100000, 999999); // Random 6-digit code
                $user->email_verification_code = $verificationCode;
                $user->save();
            } else {
                $user->email = $request->email;
                $user->phone = $request->phone_number;

                if ($request->hasFile('profile_picture')) {
                    $file = $request->file('profile_picture');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $pic = $filename; // Save the business permit
                }

                // Generate a verification code
                $verificationCode = rand(100000, 999999);
                $user->email_verification_code = $verificationCode;
                $user->profile_picture = $pic;
                $user->save();
            }
            // Send the verification code via email
            Mail::to($user->email)->send(new SendVerificationCodeMail($verificationCode));

            // Redirect the user to a verification page
            return view('emails.email_verfy', ['user' => $user])->with('success', 'a Verification code was sent to your gmail');

        } else {
            return redirect('/login')->withErrors('User not found.');
        }
    }
    public function verifyEmail(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user && $user->email_verification_code == $request->verification_code) {
            $user->email_verified_at = now();
            $user->email_verification_code = null;
            $user->save();

            Auth::login($user);
            return redirect('/home')->with('success', 'Email verified successfully!');
        } else {
            return redirect()->back()->withErrors('Invalid verification code.');
        }
    }

    public function redirectEmail($data)
    {
        $user = User::find($data);

        $verificationCode = rand(100000, 999999);

        $user->email_verification_code = $verificationCode;
        $user->save();

        Mail::to($user->email)->send(new SendVerificationCodeMail($verificationCode));

        return view('emails.email_verfy', ['user' => $user]);


    }
    public function reSend($userId)
    {
        // Retrieve the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404); // Return a 404 status code for not found
        }

        // Generate a new random verification code
        $verificationCode = rand(100000, 999999);

        Mail::to($user->email)->send(new SendVerificationCodeMail($verificationCode));
        // Save the new verification code to the user
        $user->email_verification_code = $verificationCode;
        $user->save();

        // Simulate sending an email (you would typically send the email here)
        // Mail::to($user->email)->send(new VerificationCodeEmail($verificationCode));

        // Return a successful response
        return response()->json([
            'message' => 'A verification code was sent to your email.',
        ], 200); // Return a 200 status code for success
    }


    public function register(Request $request)
    {
        // Validate form data
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
        ]);

        // Hash the password
        $fields['password'] = bcrypt($fields['password']);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_pictures', $filename);
            $fields['profile_picture'] = $filename;
        }

        // Unset password confirmation before creating the user
        unset($fields['password_confirmation']);
        // Create the user
        $data = User::create($fields);



        // Redirect the user to a verification page
        return response()->json([
            'data' => $data,
            'message' => 'A Verification code was sent to your Gmail',
        ], 200);

    }


    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'logname' => 'required|string',
            'logpassword' => 'required|string',
        ]);

        if (auth()->attempt(['username' => $fields['logname'], 'password' => $fields['logpassword']])) {
            $request->session()->regenerate();

            if (auth()->user()->email_verified_at == null) {
                return redirect()->route('send.email', auth()->user())->withErrors(['logname' => 'Please verify your email to continue.']);
            } else {
                if (auth()->user()->role === 'admin') {
                    // Redirect to the admin dashboard if the user is an admin
                    return redirect()->route('admin.dashboard');
                } else {
                    // Redirect to the home route for regular users
                    return redirect()->route('home');
                }
            }
        }
        return redirect()->back()->withErrors(['logname' => 'Invalid credentials'])->withInput();
    }

    public function getCoor(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $address = $this->getAddressFromCoordinates($latitude, $longitude);

        if ($address) {
            return response()->json($address);
        } else {
            return response()->json('Unable to get address for the coordinates.', 500);
        }
    }

    private function getAddressFromCoordinates($latitude, $longitude)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json";

        // Set the options for the HTTP context, including the User-Agent header
        $options = [
            "http" => [
                "header" => "User-Agent: RolandLopez/1.0 (lopezrolandshane@gmail.com)"
            ]
        ];
        $context = stream_context_create($options);

        // Make the request and get the response
        $response = file_get_contents($url, false, $context);

        if ($response === FALSE) {
            // Handle the error
            return false;
        }

        // Decode the JSON response
        $response = json_decode($response, true);

        // Check if the response contains the 'address' array
        if (isset($response['address'])) {
            // Get the formatted address from the response
            return $response['display_name'];
        } else {
            return false;
        }

    }
    public function showProfile()
    {
        $user = Auth::user();

        $properties = [];
        $inquiriesCount = [];
        $statistics = [];
        $currentDorm = null;
        $favorites = [];

        if ($user->role == 'owner') {
            // Fetch owner's properties
            $properties = Dorm::where('user_id', $user->id)
                ->where('archive', 0)
                ->take(13) // Limit to 3 properties
                ->get();

            // Count inquiries for each property
            foreach ($properties as $property) {
                $inquiriesCount[$property->id] = Chatroom::where('dorm_id', $property->id)->count();
            }

            // Calculate statistics
            $statistics = [
                'total_properties' => $properties->count(),
                'total_inquiries' => array_sum($inquiriesCount),
            ];
        }

        if ($user->role == 'tenant') {
            // Retrieve the user's current rented dorm
            $currentRent = RentForm::where('user_id', $user->id)
                ->where('status', 'approved') // Assuming 'approved' status indicates an active rent
                ->with('dorm')
                ->with('room') // Eager load the dorm associated with the rent
                ->first();

            if ($currentRent) {
                $currentDorm = $currentRent;
            }
        }

        return view('profile', compact('user', 'properties', 'inquiriesCount', 'statistics', 'currentDorm', 'favorites'));
    }

    public function edit($id)
    {
        $dorm = Dorm::find($id);
        return view('dorms.adddorm', compact('dorm'));
    }

    public function update(Request $request, $id)
    {
        $dorm = Dorm::findOrFail($id);

        // Ensure the logged-in user is the owner of the dorm
        if ($dorm->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rooms_available' => 'required|integer',
            'price' => 'required|numeric',
            'type' => 'required|string',
            'image' => 'nullable|array',
            'image.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'existing_images' => 'array',
            'existing_images.*' => 'string',
        ]);

        $existingImages = $request->input('existing_images', []);
        $newImageCount = $request->hasFile('image') ? count($request->file('image')) : 0;

        if (count($existingImages) + $newImageCount < 3 || count($existingImages) + $newImageCount > 6) {
            return redirect()->back()->withErrors(['image' => 'You must have between 3 and 6 images in total.']);
        }

        // Handle new images
        $newImagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/dorm_pictures', $filename);
                $newImagePaths[] = $filename;
            }
        }

        // Get existing images from the form
        $existingImages = $request->input('existing_images', []);

        // Combine new images with existing ones
        $allImages = array_merge($existingImages, $newImagePaths);

        // Remove images that are not present in the updated list
        $currentImages = json_decode($dorm->image, true);
        if (!empty($currentImages)) {
            foreach ($currentImages as $currentImage) {
                if (!in_array($currentImage, $allImages)) {
                    Storage::delete('public/dorm_pictures/' . $currentImage);
                }
            }
        }

        // Update dorm information
        $dorm->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'rooms_available' => $request->rooms_available,
            'price' => $request->price,
            'image' => json_encode($allImages),
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Dorm updated successfully!');
    }

    public function requestVerify(Request $request)
    {
        $userid = Auth::id();

        $request->validate([
            'id_document.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'business_permit.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle ID Document Image Upload

        if ($request->hasFile('id_document')) {
            $docID = $request->file('id_document');
            $filename1 = time() . '_' . uniqid() . '.' . $docID->getClientOriginalExtension();
            $idDocumentPaths = $docID->storeAs('public/id_documents', $filename1); // Save in storage/app/public/id_documents

        }

        // Handle Business Permit Image Upload

        if ($request->hasFile('business_permit')) {
            $permit = $request->file('business_permit');
            $filename2 = time() . '_' . uniqid() . '.' . $permit->getClientOriginalExtension();
            $businessPermitPath = $permit->storeAs('public/business_permits', $filename2); // Save the business permit
        }

        // Now, store the image paths in your database (example with a 'users' table):
        $verify = new Verifications();
        $verify->user_id = $userid; // Get the authenticated user
        $verify->id_document = $filename1; // Store paths in the database
        $verify->business_permit = $filename2;
        $verify->save();

        event(new NotificationEvent([

            'reciever' => 15,
            'message' => 'Verification Request was Sent',
            'sender' => Auth::id(),
            'rooms' => null,
            'roomid' => null,
            'action' => 'verify',
        ]));

        return redirect()->back()->with('success', 'Verification Request Sent!');
    }

    public function userRentForms()
    {
        $extend = [];
        $checkExtend = null;
        $pendingPayments = null;
        $pendingBills = [];
        $billingCount = null;
        $currentRent = RentForm::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'approved')
                    ->orWhere('status', 'active');
            })
            ->first();
        if ($currentRent) {
            $extend = ExtendRequest::where('form_id', $currentRent->id)->Where('status', 'pending')->first();
            $checkExtend = ExtendRequest::where('form_id', $currentRent->id)->Where('status', 'approved')->first();
            $pendingBills = Billing::where('rent_form_id', $currentRent->id)->where('status', 'pending')->first();
            $pendingPayments = Billing::where('rent_form_id', $currentRent->id)->where('status', 'pending')->whereMonth('billing_date', now()->month)->get();

            $billingCount = Billing::where('status', 'pending')
                ->where('user_id', Auth::id())
                ->whereMonth('billing_date', now()->month)
                ->count();
        }

        $paidPayments = Billing::where('status', 'paid')->where('user_id', Auth::id())->get();

        if ($currentRent) {
            $currentRent->start_date = Carbon::parse($currentRent->start_date);
            $currentRent->end_date = Carbon::parse($currentRent->end_date);
        }

        $rentHistory = RentForm::where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('status', '!=', 'pending')
                    ->Where('status', '!=', 'approved')
                    ->Where('status', '!=', 'active');
            })
            ->get()
            ->each(function ($rent) {
                $rent->start_date = Carbon::parse($rent->start_date);
                $rent->end_date = Carbon::parse($rent->end_date);
            });

        return view('userRentForms', compact('currentRent', 'rentHistory', 'extend', 'checkExtend', 'pendingBills', 'pendingPayments', 'paidPayments', 'billingCount'));
    }
    public function filterBilling(Request $request)
    {
        $month = $request->get('month');
        $type = $request->get('type');
        $userId = auth()->id();


        if ($type == 'pending') {
            // Fetch pending payments based on month and user
            $pendingPayments = Billing::where('user_id', $userId)
                ->whereMonth('billing_date', '=', date('m', strtotime($month)))
                ->where('status', 'pending')
                ->with(['rentForm.room', 'rentForm.room.dorm']) // Load relationships
                ->get();

            return response()->json(['payments' => $pendingPayments]);
        } else {
            // Fetch paid payments based on month and user
            $paidPayments = Billing::where('user_id', $userId)
                ->whereMonth('paid_at', '=', date('m', strtotime($month)))
                ->where('status', 'paid')
                ->with(['rentForm.room', 'rentForm.room.dorm']) // Load relationships
                ->get();

            return response()->json(['payments' => $paidPayments]);
        }

    }



    public function extendForm($id)
    {
        $rentForm = RentForm::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($rentForm) {
            $rentForm->start_date = Carbon::parse($rentForm->start_date);
            $rentForm->end_date = Carbon::parse($rentForm->end_date);
        }
        return view('room.extend_rent', compact('rentForm'));
    }
    public function extendRent(Request $request)
    {
        $rentForm = RentForm::findOrFail($request->form_id);

        // Validation
        $validatedData = $request->validate([
            'term' => 'required',
            'end_date' => 'nullable|date|after:' . $rentForm->end_date,
            'duration' => 'nullable|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Process extension logic based on the selected term
        if ($validatedData['term'] == 'short_term') {
            // For short term, we set a new end date
            $newEndDate = Carbon::parse($validatedData['end_date']);
        } elseif ($validatedData['term'] == 'long_term') {
            $duration = (int) $validatedData['duration'];
            $newEndDate = Carbon::parse($rentForm->end_date)->addMonths($duration);
        }

        // Update the rentForm with the new end date
        ExtendRequest::create([
            'form_id' => $rentForm->id,
            'new_end_date' => $newEndDate,
            'term' => $validatedData['term'],
            't_price' => $validatedData['total_price'],
            'new_duration' => $validatedData['duration']
        ]);

        // Return a response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Rent extended successfully!',
            'new_end_date' => $newEndDate->format('Y-m-d')
        ]);
    }
    public function extendEdit($id)
    {
        $extend = ExtendRequest::findOrFail($id);
        $rentForm = RentForm::findOrFail($extend->form_id);
        if ($rentForm) {
            $rentForm->start_date = Carbon::parse($rentForm->start_date);
            $rentForm->end_date = Carbon::parse($rentForm->end_date);
        }

        $extend->new_date_end = Carbon::parse($extend->new_date_end);

        return view('room.extend_rent', compact('extend', 'rentForm'));
    }
    public function extendUpdate(Request $request, $id)
    {
        $rentForm = RentForm::findOrFail($request->form_id);
        $extendForm = ExtendRequest::find($id);
        // Validation
        $validatedData = $request->validate([
            'term' => 'required',
            'end_date' => 'nullable|date|after:' . $rentForm->end_date,
            'duration' => 'nullable|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        // Process extension logic based on the selected term
        if ($validatedData['term'] == 'short_term') {
            // For short term, we set a new end date
            $newEndDate = Carbon::parse($validatedData['end_date']);
        } elseif ($validatedData['term'] == 'long_term') {
            $duration = (int) $validatedData['duration'];
            $newEndDate = Carbon::parse($rentForm->end_date)->addMonths($duration);
        }

        // Update the rentForm with the new end date

        $extendForm->form_id = $rentForm->id;
        $extendForm->new_end_date = $newEndDate;
        $extendForm->term = $validatedData['term'];
        $extendForm->t_price = $validatedData['total_price'];
        $extendForm->new_duration = $validatedData['duration'];
        $extendForm->save();


        // Return a response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'updated Successfully!',
            'new_end_date' => $newEndDate->format('Y-m-d')
        ]);
    }
    // RentFormController.php

    public function showOwnerDashboard()
    {
        $ownerId = auth()->id();

        // Fetch all approved rent forms with dorm, room, and tenant data
        $approvedRentForms = DB::select("
            SELECT 
                rf.id as rent_form_id,
                rf.start_date,
                rf.duration,
                rf.total_price,
                d.name AS dorm_name,
                d.address AS dorm_location,
                r.number AS room_number,
                r.id as room_id,
                u.name AS tenant_name,
                u.email AS tenant_email
            FROM rent_forms rf
            INNER JOIN dorms d ON rf.dorm_id = d.id
            INNER JOIN rooms r ON rf.room_id = r.id
            INNER JOIN users u ON rf.user_id = u.id
            WHERE d.user_id = ?
            AND rf.status = 'approved'
        ", [$ownerId]);

        // Fetch pending rent form submissions
        $pendingRentForms = DB::select("
            SELECT 
                rf.id as rent_form_id,
                rf.start_date,
                rf.duration,
                rf.created_at,
                d.name AS dorm_name,
                d.address AS dorm_location,
                r.number AS room_number,
                u.name AS tenant_name,
                u.email AS tenant_email
            FROM rent_forms rf
            INNER JOIN dorms d ON rf.dorm_id = d.id
            INNER JOIN rooms r ON rf.room_id = r.id
            INNER JOIN users u ON rf.user_id = u.id
            WHERE d.user_id = ?
            AND rf.status = 'pending'
        ", [$ownerId]);

        $extendRequests = DB::select("
        SELECT 
            er.id as extend_request_id,
            er.new_end_date,
            er.term,
            er.t_price,
            er.new_duration,
            er.status AS extend_status,
            rf.id as rent_form_id,
            d.name AS dorm_name,
            d.address AS dorm_location,
            r.number AS room_number,
            r.id as room_id,
            u.name AS tenant_name,
            u.email AS tenant_email
        FROM extend_requests er
        INNER JOIN rent_forms rf ON er.form_id = rf.id
        INNER JOIN dorms d ON rf.dorm_id = d.id
        INNER JOIN rooms r ON rf.room_id = r.id
        INNER JOIN users u ON rf.user_id = u.id
        WHERE d.user_id = ?
        AND er.status = 'pending'
    ", [$ownerId]);

        // Process the approved rent forms into properties -> rooms -> tenants structure
        $properties = [];
        foreach ($approvedRentForms as $form) {
            $propertyKey = $form->dorm_name . ' - ' . $form->dorm_location;

            if (!isset($properties[$propertyKey])) {
                $properties[$propertyKey] = [
                    'dorm_name' => $form->dorm_name,
                    'dorm_location' => $form->dorm_location,
                    'rooms' => []
                ];
            }

            $roomKey = $form->room_id;

            if (!isset($properties[$propertyKey]['rooms'][$roomKey])) {
                $properties[$propertyKey]['rooms'][$roomKey] = [
                    'number' => $form->room_number,
                    'tenants' => []
                ];
            }

            // Add tenant details
            $properties[$propertyKey]['rooms'][$roomKey]['tenants'][] = [
                'name' => $form->tenant_name,
                'email' => $form->tenant_email
            ];
        }

        $extendRequestData = [];
        foreach ($extendRequests as $request) {
            $propertyKey = $request->dorm_name . ' - ' . $request->dorm_location;

            if (!isset($extendRequestData[$propertyKey])) {
                $extendRequestData[$propertyKey] = [
                    'dorm_name' => $request->dorm_name,
                    'dorm_location' => $request->dorm_location,
                    'rooms' => []
                ];
            }

            $roomKey = $request->room_id;

            if (!isset($extendRequestData[$propertyKey]['rooms'][$roomKey])) {
                $extendRequestData[$propertyKey]['rooms'][$roomKey] = [
                    'number' => $request->room_number,
                    'tenants' => [],
                    'extend_requests' => []
                ];
            }

            // Add extend request details
            $extendRequestData[$propertyKey]['rooms'][$roomKey]['extend_requests'][] = [
                'extend_request_id' => $request->extend_request_id,
                'new_end_date' => $request->new_end_date,
                'term' => $request->term,
                't_price' => $request->t_price,
                'new_duration' => $request->new_duration,
                'extend_status' => $request->extend_status,
                'tenant_name' => $request->tenant_name,
                'tenant_email' => $request->tenant_email
            ];
        }

        return view('manage_tenant', compact('properties', 'pendingRentForms', 'extendRequestData'));
    }

    public function updateRequest(Request $request, $id)
    {
        $userId = Auth::id();
        $today = Carbon::now()->toDateString();
        $extendRent = ExtendRequest::findOrFail($id);

        $rentForm = RentForm::findOrFail($extendRent->form_id);
        $extendRent->status = $request->input('status');


        if ($request->input('status') == 'approved') {
            $room = Room::findOrFail($rentForm->room_id);
            $room->status = false;

            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => 'Extend Request approved',
                'read' => false,
                'room_id' => $rentForm->room_id,
                'sender_id' => $userId
            ]);
            $rentForm->total_price = $extendRent->t_price;
            $rentForm->term = $extendRent->term;
            $rentForm->end_date = $extendRent->new_end_date;
            if ($rentForm->term == 'long_term') {
                $rentForm->duration = $extendRent->new_duration;
            }

            if ($rentForm->term == 'short_term') {
                // Create a billing entry for the full amount (short term)
                Billing::create([
                    'user_id' => $rentForm->user_id,
                    'rent_form_id' => $rentForm->id,
                    'amount' => $rentForm->total_price,
                    'billing_date' => $rentForm->end_date,
                    'status' => 'pending', // Set initial status to pending
                ]);
            } elseif ($rentForm->term == 'long_term') {
                // Calculate the monthly payment
                $monthlyPayment = $rentForm->total_price / $rentForm->duration;

                // Generate billing for each month
                for ($i = 1; $i < $rentForm->duration + 1; $i++) {
                    // Calculate the billing date for each month
                    $billingDate = Carbon::parse($today)->addMonths($i)->toDateString();

                    // Create billing entry for the specific month
                    Billing::create([
                        'user_id' => $rentForm->user_id,
                        'rent_form_id' => $rentForm->id,
                        'amount' => $monthlyPayment,
                        'billing_date' => $billingDate,
                        'status' => 'pending', // Set initial status to pending
                    ]);
                }
            }


        } else if ($request->input('status') == 'rejected') {
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Form Response',
                'data' => 'Extend Request rejected',
                'read' => false,
                'room_id' => $rentForm->room_id,
                'sender_id' => $userId
            ]);
        }

        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $userId,
            'rooms' => $notification->id,
            'roomid' => $notification->room_id,
            'action' => 'response',
        ]));
        $rentForm->save();
        $extendRent->save();
        return redirect()->back()->with('success', 'status updated successfully.');
    }
    public function makePayment($paymentId)
    {
        // Retrieve the payment by ID
        $payment = Billing::findOrFail($paymentId);

        // Logic to handle the payment (e.g., mark as paid)
        $payment->status = 'paid';
        $payment->paid_at = now();
        $payment->save();

        // Return the updated list of pending payments (or success message)
        $pendingPayments = Billing::where('status', 'pending')->get();

        return response()->json(['message' => 'Payment successful!', 'pendingPayments' => $pendingPayments]);
    }

    public function review($id)
    {
        $review = Reviews::findOrFail($id);

        // Make sure the logged-in user is the owner of the review
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }
        if ($review->comments && $review->rating) {
            abort(403, 'Review Already submitted');
        }

        return view('reviews', compact('review'));
    }

    public function submitReview(Request $request, $id)
    {
        $review = Reviews::findOrFail($id);

        // Make sure the logged-in user is the owner of the review
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate the input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        // Update the review
        $review->update([
            'rating' => $request->rating,
            'comments' => $request->comments,
        ]);

        return redirect()->route('home')->with('success', 'Review submitted successfully!');
    }

    public function userReviews()
    {
        $userId = auth()->id();

        // Fetch pending reviews where the user hasn't submitted a rating yet
        $pendingReviews = Reviews::where('user_id', $userId)
            ->whereNull('rating')
            ->with('room.dorm')
            ->get();

        // Fetch past reviews where the user has already submitted a rating
        $pastReviews = Reviews::where('user_id', $userId)
            ->whereNotNull('rating')
            ->with('room.dorm')
            ->get();

        return view('user_reviews', compact('pendingReviews', 'pastReviews'));
    }

}
