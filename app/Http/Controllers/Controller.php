<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\CurseWords;
use App\Models\Reviews;
use Crypt;
use DB;
use Carbon\Carbon;
use App\Models\Dorm;
use App\Models\User;
use App\Models\Billing;
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
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Str;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
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
                return view('emails.collect_email_phone', ['user' => $user])->with('success', 'Provide additional information. to login');
            } else {
                // If the user exists, simply log them in and redirect to home
                if (!$user->email) {
                    return view('emails.collect_email_phone', ['user' => $user])->withErrors(['logname', 'Provide gmail and Phone no. to login']);
                } else if ($user->email_verified_at == null) {
                    return redirect()->route('send.email', [Crypt::encrypt($user->id), 'verify'])->withErrors(['logname' => 'Please verify your email to continue.']);
                } else {
                    Auth::login($user);
                    if ($user->role == 'owner') {
                        return redirect()->route('owner.Dashboard');
                    } else {
                        return redirect('/home');
                    }
                }
            }

        } catch (\Exception $e) {
            // Handle errors
            return redirect('/login');
        }
    }


    public function collectEmailPhone(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $request->validate([
            'email' => !$user->email
                ? [
                    'required',
                    'email',
                    Rule::unique('users', 'email'),
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
                ]
                : 'nullable|email',
            'role' => 'required',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string|max:255',
            'phone_number' => ['required', 'regex:/^\+?[0-9]{7,15}$/'],  // Example: Simple international phone number regex
        ]);

        if ($user->fb_id) {
            $user->email = $request->email;
            $user->phone = $request->phone_number;
            $user->role = $request->role;
            $user->address = $request->address;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = Str::random(25) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile_picture', $filename, 'gcs');
            }

            if ($request->role == 'owner') {
                $request->validate([
                    'valid_id' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'business_permit' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                $verify = new Verifications();
                $verify->user_id = $user->id;

                // Upload valid_id if provided
                if ($request->hasFile('valid_id')) {
                    $validIdFile = $request->file('valid_id');
                    $validIdFilename = Str::random(25) . '.' . $validIdFile->getClientOriginalExtension();
                    $validIdPath = $validIdFile->storeAs('owner_documents/valid_id', $validIdFilename, 'gcs');
                    $verify->id_document = $validIdPath;
                }

                // Upload business_permit if provided
                if ($request->hasFile('business_permit')) {
                    $businessPermitFile = $request->file('business_permit');
                    $businessPermitFilename = Str::random(25) . '.' . $businessPermitFile->getClientOriginalExtension();
                    $businessPermitPath = $businessPermitFile->storeAs('owner_documents/business_permit', $businessPermitFilename, 'gcs');
                    $verify->business_permit = $businessPermitPath;
                }

                $verify->save();

                // Notification for admin
                $notification = Notification::create([
                    'user_id' => 14, // Assuming the owner is linked to the room
                    'type' => 'Bills',
                    'data' => '<strong>User Verification Pending</strong><br><p>A user has registered as an owner and is awaiting verification. Please review their application.</p><p><strong>User:</strong> ' . $user->name . '</p><p><strong>Email:</strong> ' . $user->email . '</p><p><strong>Registered on:</strong> ' . $user->created_at->format('Y-m-d H:i:s') . '</p><br><p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                    'read' => false,
                    'route' => route('admin.manageuser'),
                    'dorm_id' => null,
                    'sender_id' => $user->id,
                ]);

                event(new NotificationEvent([
                    'reciever' => $notification->user_id,
                    'message' => $notification->data,
                    'sender' => $user->id,
                    'rooms' => $notification->id,
                    'roomid' => $notification->dorm_id,
                    'action' => 'Verify',
                    'route' => route('admin.manageuser')
                ]));

                // Generate a verification code
                $verificationCode = rand(100000, 999999);
                $user->email_verification_code = $verificationCode;
                $user->profile_picture = $path;
                $user->save();

                // Send email with verification code
                Mail::to($user->email)->send(new SendVerificationCodeMail($verificationCode));

                Auth::login($user);
                return response()->json([
                    'success' => true,
                    'message' => 'A verification code was sent to your email.',
                    'redirect_url' => route('owner.Dashboard')
                ]);
            }

            // If no 'owner' role, just save profile picture
            $user->profile_picture = $path;
            $user->save();

            // Default login redirect after successful registration
            Auth::login($user);
            return response()->json([
                'success' => true,
                'message' => 'Your registration is complete.',
                'redirect_url' => route('home')
            ]);
        } else if ($user->google_id) {
            // Similar logic for Google account
            $user->phone = $request->phone_number;
            $user->role = $request->role;
            $user->address = $request->address;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = Str::random(25) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile_picture', $filename, 'gcs');
            }

            $user->profile_picture = $path;
            $user->save();

            if ($request->role == 'owner') {
                $request->validate([
                    'valid_id' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                    'business_permit' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                $verify = new Verifications();
                $verify->user_id = $user->id;

                if ($request->hasFile('valid_id')) {
                    $validIdFile = $request->file('valid_id');
                    $validIdFilename = Str::random(25) . '.' . $validIdFile->getClientOriginalExtension();
                    $validIdPath = $validIdFile->storeAs('owner_documents/valid_id', $validIdFilename, 'gcs');
                    $verify->id_document = $validIdPath;
                }

                if ($request->hasFile('business_permit')) {
                    $businessPermitFile = $request->file('business_permit');
                    $businessPermitFilename = Str::random(25) . '.' . $businessPermitFile->getClientOriginalExtension();
                    $businessPermitPath = $businessPermitFile->storeAs('owner_documents/business_permit', $businessPermitFilename, 'gcs');
                    $verify->business_permit = $businessPermitPath;
                }

                $verify->save();

                // Notification for admin
                $notification = Notification::create([
                    'user_id' => 14, // Assuming the owner is linked to the room
                    'type' => 'Bills',
                    'data' => '<strong>User Verification Pending</strong><br><p>A user has registered as an owner and is awaiting verification. Please review their application.</p><p><strong>User:</strong> ' . $user->name . '</p><p><strong>Email:</strong> ' . $user->email . '</p><p><strong>Registered on:</strong> ' . $user->created_at->format('Y-m-d H:i:s') . '</p><br><p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                    'read' => false,
                    'route' => route('admin.manageuser'),
                    'dorm_id' => null,
                    'sender_id' => $user->id,
                ]);

                event(new NotificationEvent([
                    'reciever' => $notification->user_id,
                    'message' => $notification->data,
                    'sender' => $user->id,
                    'rooms' => $notification->id,
                    'roomid' => $notification->dorm_id,
                    'action' => 'Verify',
                    'route' => route('admin.manageuser')
                ]));

                // Successful login after Google registration
                Auth::login($user);
                return response()->json([
                    'success' => true,
                    'message' => 'Your registration is complete.',
                    'redirect_url' => route('owner.Dashboard')
                ]);
            }

            // Default login redirect for Google account after registration
            Auth::login($user);
            return response()->json([
                'success' => true,
                'message' => 'Your registration is complete.',
                'redirect_url' => route('home')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ]);
        }
    }

    public function verifyEmail(Request $request)
    {
        $user = User::find($request->user_id);
        // dd($user);
        if ($user) {
            if ($user->email_verification_code == $request->verification_code) {
                if ($request->action == 'verify') {
                    $user->email_verified_at = now();
                    $user->email_verification_code = null;
                    $user->save();
                    Auth::login($user);

                    return redirect('/home')->with('success', 'Email verified successfully!');
                } elseif ($request->action == 'forgot') {
                    $user->email_verified_at = now();
                    $user->email_verification_code = null;
                    $user->save();
                    return redirect()->route('reset.pass', Crypt::encrypt($user->id))->with('success', 'Code Verified.');
                } else {
                    return redirect()->back()->withErrors('Invalid Action');
                }

            } else {
                return redirect()->back()->withErrors('Invalid verification code.');
            }
        } else {
            return redirect()->back()->withErrors('User not found.');
        }
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',  // password confirmation handled
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Assuming user ID or email is passed to identify the user
        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not found.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Log out the user and redirect with a success message
        Auth::logout();
        session()->flash('success', 'Your password has been reset successfully. Please log in again.');

        return redirect()->route('login');


    }

    public function forgotPass(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // dd($user);
        if (!$user) {
            return redirect()->back()->withErrors(['logname' => 'No email Found for ' . $request->email]);
        }
        // Attach the reset_password value

        return redirect()->route('send.email', [Crypt::encrypt($user->id), 'forgot'])->withErrors(['logname' => 'A reset Code has sent to your email']);
    }
    public function resetPass($data)
    {
        $id = Crypt::decrypt(request('data'));
        $user = User::findOrFail($id);


        return view('reset-pass', compact('user'));
    }

    public function redirectEmail($id, $action)
    {
        $data = Crypt::decrypt(request('id'));
        $user = User::find($data);

        $verificationCode = rand(100000, 999999);
        if ($user->email_verification_code == null) {
            $user->email_verification_code = $verificationCode;
            $user->save();
            Mail::to($user->email)->send(new SendVerificationCodeMail($verificationCode));
        }
        $user->action = $action;
        // dd($user);
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
        // Validate form data with conditional fields for owner
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'valid_id' => $request->role === 'owner' ? 'required|image|mimes:jpeg,png,jpg|max:2048' : 'nullable',
            'business_permit' => $request->role === 'owner' ? 'required|image|mimes:jpeg,png,jpg|max:2048' : 'nullable',
        ]);

        // Hash the password
        $fields['password'] = bcrypt($fields['password']);

        // Handle profile picture upload to Google Cloud Storage
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = Str::random(25) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_picture', $filename, 'gcs');
            $fields['profile_picture'] = $path;
        }

        // Create the user
        $user = User::create($fields);

        // Additional steps if the user is an owner
        if ($request->role === 'owner') {
            $verify = new Verifications();
            $verify->user_id = $user->id;

            // Upload valid_id if provided
            if ($request->hasFile('valid_id')) {
                $validIdFile = $request->file('valid_id');
                $validIdFilename = Str::random(25) . '.' . $validIdFile->getClientOriginalExtension();
                $validIdPath = $validIdFile->storeAs('owner_documents/valid_id', $validIdFilename, 'gcs');
                $verify->id_document = $validIdPath;
            }

            // Upload business_permit if provided
            if ($request->hasFile('business_permit')) {
                $businessPermitFile = $request->file('business_permit');
                $businessPermitFilename = Str::random(25) . '.' . $businessPermitFile->getClientOriginalExtension();
                $businessPermitPath = $businessPermitFile->storeAs('owner_documents/business_permit', $businessPermitFilename, 'gcs');
                $verify->business_permit = $businessPermitPath;
            }

            $verify->save();

            $notification = Notification::create([
                'user_id' => 14, // Assuming the owner is linked to the room
                'type' => 'Bills',
                'data' => '<strong>User Verification Pending</strong><br><p>A user has registered as an owner and is awaiting verification. Please review their application.</p><p><strong>User:</strong> ' . $user->name . '</p><p><strong>Email:</strong> ' . $user->email . '</p><p><strong>Registered on:</strong> ' . $user->created_at->format('Y-m-d H:i:s') . '</p><br><p>Sent on: ' . now()->format('Y-m-d H:i:s') . '</p>',
                'read' => false,
                'route' => route('admin.manageuser'),
                'dorm_id' => null,
                'sender_id' => $verify->user_id,
            ]);

            event(new NotificationEvent([
                'reciever' => $notification->user_id,
                'message' => $notification->data,
                'sender' => $verify->user_id,
                'rooms' => $notification->id,
                'roomid' => $notification->dorm_id,
                'action' => 'Verify',
                'route' => route('admin.manageuser')
            ]));
        }
        $user->encrypted_id = Crypt::encrypt($user->id);
        // Redirect the user to a verification page
        return response()->json([
            'data' => $user,
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

        // Check if the input is an email or a username
        $loginType = filter_var($fields['logname'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt login with the determined field (either 'email' or 'username')
        if (auth()->attempt([$loginType => $fields['logname'], 'password' => $fields['logpassword']])) {

            $request->session()->regenerate();

            if (auth()->user()->email_verified_at == null) {
                return redirect()->route('send.email', ['user' => Crypt::encrypt(auth()->id()), 'action' => 'verify'])
                    ->withErrors(['logname' => 'Please verify your email to continue.']);

            } else {
                if (auth()->user()->role === 'admin') {
                    // Redirect to the admin dashboard if the user is an admin
                    return redirect()->route('admin.dashboard');
                } else if (auth()->user()->role === 'owner') {
                    return redirect()->route('owner.Dashboard');
                } else {
                    // Redirect to the home route for regular users
                    return redirect()->route('home');
                }
            }
        }
        return redirect()->back()->withErrors(['logname' => 'Invalid credentials'])->withInput();
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request data
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore(auth()->user()->id),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore(auth()->user()->id),
            ],
            'mobile_phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update the user's details
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->phone = $request->input('mobile_phone');
        $user->address = $request->input('address');

        // Check if a new profile picture is uploaded
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture) {
                Storage::disk('gcs')->delete($user->profile_picture);
            }

            // Store the new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'gcs');
            $user->profile_picture = $path;
        }

        // Save the updated user data
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
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

        if (auth()->user()->role == 'owner') {
            Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
                $trail->parent('owner.Dashboard');
                $trail->push('Edit Profile', route('admin.manageuser'));
            });
            ;
        } elseif (auth()->user()->role == 'tenant') {
            Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
                $trail->parent('home');
                $trail->push('Edit Profile', route('admin.manageuser'));
            });
        } elseif (auth()->user()->role == 'admin') {
            Breadcrumbs::for('profile.edit', function (BreadcrumbTrail $trail) {
                $trail->parent('admin.dashboard');
                $trail->push('Edit Profile', route('admin.manageuser'));
            });
        }

        return view('profile', compact('user'));
    }

    public function edit($data)
    {
        $id = Crypt::decrypt(request('data'));
        $dorm = Dorm::find($id);
        Breadcrumbs::for('dorms.adddorm', function (BreadcrumbTrail $trail) use ($dorm) {
            $trail->parent('owner.Property');
            $trail->push('edit ' . $dorm->name, route('dorms.adddorm', $dorm->id));
        });
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
            'price' => 'required|numeric',
            'guest_capacity' => 'required|numeric',
            'beds' => 'required|numeric',
            'bedrooms' => 'required|numeric',
            'image' => 'nullable|array|min:3|max:6',
            'image.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'existing_images' => 'array',
            'existing_images.*' => 'string',
        ]);

        // Prepare existing and new images
        $existingImages = $request->input('existing_images', []);
        $newImageCount = $request->hasFile('image') ? count($request->file('image')) : 0;

        if (count($existingImages) + $newImageCount < 3 || count($existingImages) + $newImageCount > 6) {
            return redirect()->back()->withErrors(['image' => 'You must have between 3 and 6 images in total.']);
        }

        // Collect new image paths
        $newImagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('dorm_pictures', $filename, 'gcs');
                $newImagePaths[] = $path;
            }
        }

        // Merge existing and new images
        $allImages = array_merge($existingImages, $newImagePaths);

        // Remove any old images not included in the update
        $currentImages = json_decode($dorm->image, true) ?? [];
        foreach ($currentImages as $currentImage) {
            if (!in_array($currentImage, $allImages)) {
                Storage::disk('gcs')->delete($currentImage);  // Delete only missing images
            }
        }

        // Update dorm record with all new data
        $dorm->update([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price' => $request->price,
            'capacity' => $request->guest_capacity,
            'beds' => $request->beds,
            'bedroom' => $request->bedrooms,
            'image' => json_encode($allImages),
        ]);

        return redirect()->back()->with('success', 'Accommodation updated successfully!');
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
            $pendingBills = Billing::where('user_id', Auth::id())->where('status', 'pending')->get();
            $pendingPayments = Billing::where('user_id', Auth::id())->where('status', 'pending')->get();

            $billingCount = Billing::where('status', 'pending')
                ->where('user_id', Auth::id())
                ->count();
        }

        $paidPayments = Billing::where('status', 'paid')->where('user_id', Auth::id())->get();

        if ($currentRent) {
            $currentRent->start_date = Carbon::parse($currentRent->start_date);
            $currentRent->end_date = Carbon::parse($currentRent->end_date);
        }

        $rentHistory = RentForm::where('user_id', auth()->id())->with('dorm')
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





    public function extendForm($id)
    {
        $rentForm = RentForm::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($rentForm) {
            $rentForm->start_date = Carbon::parse($rentForm->start_date);
            $rentForm->end_date = Carbon::parse($rentForm->end_date);
        }
        return view('room.extend_rent', compact('rentForm'));
    }


    // RentFormController.php

    public function showOwnerDashboard()
    {
        $ownerId = auth()->id();

        // Fetch all approved rent forms with dorm, room, and tenant data
        $approvedRentForms = DB::select("
            SELECT 
                rf.id as rent_form_id,
                rf.start_date as start_date,
                rf.end_date as end_date,
                rf.status as rent_status,
                rf.total_price,
                d.name AS dorm_name,
                d.address AS dorm_location,
                d.id as dorm_id,
                u.id as user_id,
                u.name AS tenant_name,
                u.email AS tenant_email
            FROM rent_forms rf
            INNER JOIN dorms d ON rf.dorm_id = d.id
            INNER JOIN users u ON rf.user_id = u.id
            WHERE d.user_id = ?
            AND (rf.status = 'approved' OR rf.status = 'active');
        ", [$ownerId]);

        // Fetch pending rent form submissions
        $pendingRentForms = DB::select("
            SELECT 
                rf.id as rent_form_id,
                rf.start_date,
                 rf.end_date,
                  rf.total_price,
                rf.created_at,
                 rf.user_id,
                d.name AS dorm_name,
                d.address AS dorm_location,
                 d.id as dorm_id,
                u.name AS tenant_name,
                u.email AS tenant_email
            FROM rent_forms rf
            INNER JOIN dorms d ON rf.dorm_id = d.id
            INNER JOIN users u ON rf.user_id = u.id
            WHERE d.user_id = ?
            AND rf.status = 'pending'
        ", [$ownerId]);

        $cancellations = DB::select("
        SELECT 
            rf.id as rent_form_id,
            rf.start_date,
            rf.created_at,
            rf.updated_at,
            rf.user_id,
            d.name AS dorm_name,
              rf.status as rent_status,
            d.address AS dorm_location,
            rf.note AS cancel_reason,
             d.id as dorm_id,
            u.name AS tenant_name,
            u.email AS tenant_email
        FROM rent_forms rf
        INNER JOIN dorms d ON rf.dorm_id = d.id
        INNER JOIN users u ON rf.user_id = u.id
        WHERE d.user_id = ?
        AND rf.note != '' AND rf.status = 'approved' 
    ", [$ownerId]);

        $pendingRentFormsCount = DB::select("
        SELECT COUNT(*) as count
        FROM rent_forms rf
        INNER JOIN dorms d ON rf.dorm_id = d.id
        INNER JOIN users u ON rf.user_id = u.id
        WHERE d.user_id = ?
        AND rf.status = 'pending'
    ", [$ownerId]);

        $cancellationsCount = DB::select("
        SELECT COUNT(*) as count
        FROM rent_forms rf
        INNER JOIN dorms d ON rf.dorm_id = d.id
        INNER JOIN users u ON rf.user_id = u.id
        WHERE d.user_id = ?
        AND rf.note != '' AND rf.status = 'approved' 
    ", [$ownerId]);

        $counts = $cancellationsCount[0]->count;

        $count = $pendingRentFormsCount[0]->count;
        // Process the approved rent forms into properties -> rooms -> tenants structure

        $properties = [];
        foreach ($approvedRentForms as $form) {
            $propertyKey = $form->dorm_name . ' - ' . $form->dorm_location;

            if (!isset($properties[$propertyKey])) {
                $properties[$propertyKey] = [
                    'dorm_name' => $form->dorm_name,
                    'dorm_location' => $form->dorm_location,
                    'dorms' => []
                ];
            }

            $dormKey = $form->dorm_id;

            if (!isset($properties[$propertyKey]['dorms'][$dormKey])) {
                $properties[$propertyKey]['dorms'][$dormKey] = [
                    'name' => $form->dorm_name,
                    'tenants' => []
                ];
            }

            $pendingPayments = Billing::where('rent_form_id', $form->rent_form_id)->where('status', 'pending')->get();
            $paidPayments = Billing::where('rent_form_id', $form->rent_form_id)->where('status', 'paid')->get();

            // Add tenant details
            $properties[$propertyKey]['dorms'][$dormKey]['tenants'][] = [
                'user_id' => $form->user_id,
                'name' => $form->tenant_name,
                'email' => $form->tenant_email,
                'start_date' => $form->start_date,
                'end_date' => $form->end_date,
                'status' => $form->rent_status,
                'pending_bills' => $pendingPayments,
                'paid_bills' => $paidPayments
            ];
        }


        return view('manage_tenant', compact('properties', 'pendingRentForms', 'cancellations', 'count', 'counts'));
    }

    public function updateRequest(Request $request, $id)
    {
        $userId = Auth::id();
        $rentForm = RentForm::findOrFail($id);

        if ($request->input('status') == 'approved') {
            $rentForm->status = 'cancelled';
            $data = '<strong>Booking Cancellation Approved</strong><br>' .
                '<p>Your request for cancellation has been processed successfully.</p><br>' .
                '<p>Sent on' . now()->format('Y-m-d H:i:s') . '</p>';
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Cancellation Response',
                'data' => $data,
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $userId
            ]);

            $dorm = Dorm::find($rentForm->dorm_id);
            $dorm->availability = false;
            $dorm->save();

        } else if ($request->input('status') == 'rejected') {
            $data = '<strong>Booking Cancellation Rejected</strong><br>' .
                '<p>Unfortunately, your request for cancellation has been declined.</p><br>' .
                '<p>Sent on' . now()->format('Y-m-d H:i:s') . '</p>';
            $rentForm->note = null;
            $notification = Notification::create([
                'user_id' => $rentForm->user_id, // Assuming the owner is linked to the room
                'type' => 'Cancellation Response',
                'data' => $data,
                'read' => false,
                'route' => route('user.rentForms'),
                'dorm_id' => $rentForm->dorm_id,
                'sender_id' => $userId
            ]);


        }

        event(new NotificationEvent([
            'reciever' => $notification->user_id,
            'message' => $notification->data,
            'sender' => $userId,
            'rooms' => $notification->id,
            'roomid' => $notification->dorm_id,
            'action' => 'response',
            'route' => route('user.rentForms')
        ]));
        $rentForm->save();
        return redirect()->back()->with('success', 'status updated successfully.');
    }


    public function review($data)
    {
        $id = Crypt::decrypt(request('data'));
        $review = Reviews::findOrFail($id);
        $dorm = Dorm::find($review->dorm_id);
        // Make sure the logged-in user is the owner of the review
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }

        Breadcrumbs::for('reviews.store', function (BreadcrumbTrail $trail) use ($dorm) {
            $trail->parent('myReviews');
            $trail->push('Review: ' . $dorm->name, route('reviews.store', $dorm->id));
        });

        return view('reviews', compact('review'));
    }

    public function submitReview(Request $request, $id)
    {
        // Find the review by ID
        $review = Reviews::findOrFail($id);

        // Find the user who made the review
        $user = User::findOrFail($review->user_id);
        $warnReason = 'Your review contains inappropriate words.';

        // Validate input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ]);

        // Get the list of curse words from the database
        $curseWords = CurseWords::pluck('word')->map(function ($word) {
            return strtolower(trim($word));  // Normalize the curse words to lowercase
        })->toArray();

        // Normalize the user's comment (lowercase for case-insensitive comparison)
        $comments = strtolower($request->comments);

        // Check if any curse word is found in the comment
        foreach ($curseWords as $curseWord) {
            if (strpos($comments, $curseWord) !== false) {
                // Decrement user's strike count if a curse word is detected
                if ($user->strike > 0) {
                    $user->strike -= 1;
                }

                // Check if user should be deactivated (i.e., strikes are exhausted)
                if ($user->strike <= 0) {
                    $user->active_status = false;  // Deactivate the user
                    $user->note = $warnReason;  // Set the warning reason
                }

                // Save the updated user
                $user->save();

                // Create a notification about the warning
                $notification = Notification::create([
                    'user_id' => $user->id,
                    'type' => 'warning',
                    'data' => "<strong>Warning issued:</strong> <br> <p>" . $warnReason . "</p> <br>" .
                        "<strong>You have " . $user->strike . " remaining Strike(s)</strong>",
                    'read' => false,
                    'route' => null,
                    'dorm_id' => null,
                    'sender_id' => Auth::id(),  // Sender is the logged-in user (admin or moderator)
                ]);

                // Trigger the notification event for broadcasting
                event(new NotificationEvent([
                    'reciever' => $notification->user_id,
                    'message' => $notification->data,
                    'sender' => Auth::id(),
                    'rooms' => $notification->id,
                    'roomid' => null,
                    'action' => 'warning',
                    'route' => null
                ]));

                // Redirect with an error if a curse word was found
                return redirect()->back()->withErrors([
                    'comments' => 'Your review contains inappropriate words. Please edit and try again.'
                ])->withInput();
            }
        }

        // If no curse words were found, update the review as normal
        $review->update([
            'rating' => $request->rating,
            'comments' => $request->comments,
        ]);

        // Redirect to home with a success message
        return redirect()->route('home')->with('success', 'Review submitted successfully!');
    }

    public function userReviews()
    {
        $userId = auth()->id();

        // Fetch pending reviews where the user hasn't submitted a rating yet
        $pendingReviews = Reviews::where('user_id', $userId)
            ->whereNull('rating')
            ->with('dorm')
            ->get();

        // Fetch past reviews where the user has already submitted a rating
        $pastReviews = Reviews::where('user_id', $userId)
            ->whereNotNull('rating')
            ->with('dorm')
            ->get();

        return view('user_reviews', compact('pendingReviews', 'pastReviews'));
    }

    public function ownerDashboard()
    {
        $userId = auth()->id();

        // Fetch all dorms owned by the user
        $ownerDorms = Dorm::where('user_id', $userId)->where('archive', 0)->where('flag', 0)->get();

        // Count total properties (dorms)
        $totalProperties = $ownerDorms->count();

        // Collect all tenants with 'active' or 'approved' status for the owner's dorms
        $tenants = RentForm::whereIn('dorm_id', $ownerDorms->pluck('id'))
            ->whereIn('status', ['active', 'approved'])
            ->with('tenant')
            ->get();

        // Count the number of unique tenants


        // Collect all pending rent requests for the owner's dorms
        $pendingRequests = RentForm::whereIn('dorm_id', $ownerDorms->pluck('id'))
            ->where('status', 'pending')
            ->get();

        // Calculate total earnings for the current month from paid bills
        $monthlyEarnings = Billing::whereHas('rentForm', function ($query) use ($ownerDorms) {
            $query->whereIn('dorm_id', $ownerDorms->pluck('id'));
        })
            ->where('status', 'paid') // Assuming 'paid' is the status for paid bills
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

        $ownerDormIds = $ownerDorms->pluck('id')->toArray();

        if (!empty($ownerDormIds)) {
            $query = "
                    SELECT rent_forms.dorm_id, dorms.name, dorms.address, SUM(billings.amount) AS total_earnings
                    FROM billings
                    INNER JOIN rent_forms ON billings.rent_form_id = rent_forms.id
                    INNER JOIN dorms ON rent_forms.dorm_id = dorms.id
                    WHERE rent_forms.dorm_id IN (" . implode(',', $ownerDormIds) . ")
                    AND billings.status = 'paid'
                    AND MONTH(billings.paid_at) = ?
                    GROUP BY rent_forms.dorm_id, dorms.name, dorms.address
                ";

            $monthlyEarningsPerDorm = DB::select($query, [now()->month]);
        } else {
            $monthlyEarningsPerDorm = []; // Return an empty array if there are no dorm IDs
        }
        $bookingRates = [];

        foreach ($ownerDorms as $dorm) {
            // Count the number of completed RentForms for the dorm
            $completedBookings = RentForm::where('dorm_id', $dorm->id)
                ->where('status', '!=', 'cancelled')
                ->count();

            // Count the number of cancellations for the dorm
            $canceledBookings = RentForm::where('dorm_id', $dorm->id)
                ->where('status', 'cancelled')
                ->count();

            // Total number of bookings (completed + canceled)
            $totalBookings = $completedBookings + $canceledBookings;

            // Calculate booking rate as a percentage of completed bookings, with a cap at 100%
            $bookingRate = $totalBookings > 0 ? ($completedBookings / $totalBookings) * 100 : 0;

            $bookingRates[] = [
                'dorm' => $dorm->name,
                'bookingRate' => round($bookingRate, 2),
                'bookingCount' => $completedBookings,
                'cancellationCount' => $canceledBookings,
            ];
        }

        return view('owner-home', compact(
            'totalProperties',
            'pendingRequests',
            'monthlyEarnings',
            'bookingRates',
            'ownerDorms',
            'tenants',
            'monthlyEarningsPerDorm'
        ));
    }
    public function submitMesage(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:5000',
        ]);
        try {
            // Send email using Laravel Mail
            Mail::to('lopezrolandshane@gmail.com') // Replace with the recipient's email
                ->send(new ContactMessageMail(
                    $validatedData['name'],
                    $validatedData['email'],
                    $validatedData['message']
                ));

            return response()->json(['success' => 'Message sent successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send message. Please try again later.'], 500);
        }
    }
}
