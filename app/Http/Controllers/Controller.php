<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\User;
use App\Models\Chatroom;
use App\Models\RentForm;
use Illuminate\Http\Request;
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
use Carbon\Carbon;
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
        $currentRent = RentForm::where('user_id', auth()->id())
            ->where('status', 'pending')->orWhere('status', 'approved') // Or whatever condition fits
            ->first();

        if ($currentRent) {
            $currentRent->start_date = Carbon::parse($currentRent->start_date);
            $currentRent->end_date = Carbon::parse($currentRent->end_date);
        }

        $rentHistory = RentForm::where('user_id', auth()->id())
            ->where('status', '!=', 'pending')
            ->get()
            ->each(function ($rent) {
                $rent->start_date = Carbon::parse($rent->start_date);
                $rent->end_date = Carbon::parse($rent->end_date);
            });

        return view('userRentForms', compact('currentRent', 'rentHistory'));
    }


}
