<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\User;
use App\Models\Chatroom;
use App\Models\RentForm;
use App\Models\Verifications;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function register(Request $request)
    {
        // Validate form data
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')],
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'role' => 'required|string',
            'gender' => 'nullable|string|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
        User::create($fields);

        // Return a JSON success response
        return response()->json(['message' => 'Register Success'], 200);
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

            // Check the role of the authenticated user
            if (auth()->user()->role === 'admin') {
                // Redirect to the admin dashboard if the user is an admin
                return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
            } else {
                // Redirect to the home route for regular users
                return redirect()->route('home')->with('success', 'You have successfully logged in.');
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
            $properties = Dorm::where('user_id', $user->id)->where('archive', 0)->get();

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
        $idDocumentPaths = null;
        if ($request->hasFile('id_document')) {
            $docID = $request->file('id_document');
            $filename = time() . '_' . uniqid() . '.' . $docID->getClientOriginalExtension();
            $idDocumentPaths = $docID->storeAs('public/id_documents', $filename); // Save in storage/app/public/id_documents

        }

        // Handle Business Permit Image Upload
        $businessPermitPath = null;
        if ($request->hasFile('business_permit')) {
            $permit = $request->file('business_permit');
            $filename = time() . '_' . uniqid() . '.' . $permit->getClientOriginalExtension();
            $businessPermitPath = $permit->storeAs('public/business_permits', $filename); // Save the business permit
        }

        // Now, store the image paths in your database (example with a 'users' table):
        $verify = new Verifications();
        $verify->user_id = $userid; // Get the authenticated user
        $verify->id_document = $idDocumentPaths; // Store paths in the database
        $verify->business_permit = $businessPermitPath;
        $verify->save();

        return redirect()->back()->with('success', 'Verification Request Sent!');
    }
}
