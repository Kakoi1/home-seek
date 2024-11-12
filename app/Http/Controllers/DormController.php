<?php
namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Dorm;
use App\Models\RentForm;
use App\Models\Reports;
use App\Models\Reviews;
use App\Models\Room;
use App\Models\Favorite;
use App\Models\PropertyView;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\User;

class DormController extends Controller
{
    public function saveDorm(Request $request)
    {
        // Validate form input
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
            'image' => 'required|array|min:3|max:6',
            'image.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Process and store images
        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('dorm_pictures', $filename, 'gcs');
                $imagePaths[] = $path;
            }
        }
        $imaging = json_encode($imagePaths);

        // Create dorm record
        $dorm = Dorm::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'price' => $request->price,
            'capacity' => $request->guest_capacity,
            'beds' => $request->beds,
            'bedroom' => $request->bedrooms,
            'image' => $imaging,
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Dorm added successfully!');
    }

    public function showDorms()
    {
        $dorms = Dorm::where('archive', 0)->where('availability', 0)->where('flag', 0)->get();
        return view('dorms.map', compact('dorms'));
    }
    public function index(Request $request)
    {
        $query = Dorm::query();

        // Apply search filters
        if ($request->has('search')) {
            $search = $request->input('search');
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%');
                });
            }
        }

        // Apply price filters
        if ($request->has('min_price')) {
            $min_price = $request->input('min_price');
            if (!empty($min_price)) {
                $query->where('price', '>=', $min_price);
            }
        }
        if ($request->has('max_price')) {
            $max_price = $request->input('max_price');
            if (!empty($max_price)) {
                $query->where('price', '<=', $max_price);
            }
        }
        if ($request->has('rooms_avail')) {
            $rooms_avail = $request->input('rooms_avail');
            if (!empty($rooms_avail)) {
                $query->where('rooms_available', '>=', $rooms_avail);
            }
        }

        // Order by latest posted dorms
        $query->orderBy('created_at', 'desc')->withCount('favoritedBy')->where('availability', false)->where('archive', false)->where('flag', false);
        $query->with('reviews');
        // Paginate results
        $dorms = $query->paginate(12);

        // Append query parameters to pagination links
        $dorms->appends($request->except('page'));

        if ($request->ajax()) {
            return response()->json([
                'dorms' => view('partials.dorms', compact('dorms'))->render(),
                'pagination' => (string) $dorms->links()
            ]);
        }


        return view('home', compact('dorms'));
    }

    public function adddorm()
    {
        $dorm = '';
        Breadcrumbs::for('adddorm', function (BreadcrumbTrail $trail) use ($dorm) {
            $trail->parent('owner.Property');
            $trail->push('list a property', route('adddorm'));
        });
        return view('dorms.adddorm', compact('dorm'));
    }
    public function show($id)
    {
        $user = auth()->user();
        $dorm = Dorm::with('user')->findOrFail($id);
        $rooms = Room::where('dorm_id', $dorm->id)->count();
        $hasPendingOrActiveRentForm = RentForm::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'active', 'approved'])
            ->exists();
        if ($dorm->availability) {
            return back()->withErrors('Property not Available');
        }
        if ($dorm->archive) {
            return back()->withErrors('Property is Deleted');
        }
        $propertyReview = Dorm::with([
            'reviews' => function ($query) {
                $query->where('rating', '>', 0); // Only include reviews with a rating greater than 0
            }
        ])->findOrFail($id);

        if (auth()->user()->role == 'owner') {
            Breadcrumbs::for('dorms.posted', function (BreadcrumbTrail $trail) use ($dorm) {
                $trail->parent('owner.Property');
                $trail->push($dorm->name, route('dorms.posted', $dorm->id));
            });
        } elseif (auth()->user()->role == 'tenant') {
            Breadcrumbs::for('dorms.posted', function (BreadcrumbTrail $trail) use ($dorm) {
                $trail->parent('home');
                $trail->push($dorm->name, route('dorms.posted', $dorm->id));
            });
        } elseif (auth()->user()->role == 'admin') {
            Breadcrumbs::for('dorms.posted', function (BreadcrumbTrail $trail) use ($dorm) {
                $trail->parent('admin.manageProp');
                $trail->push($dorm->name, route('dorms.posted', $dorm->id));
            });
        }
        return view('dorms.posted', compact('dorm', 'rooms', 'propertyReview', 'hasPendingOrActiveRentForm'));
    }

    public function archive($id)
    {
        $dorm = Dorm::findOrFail($id);
        $dorm->update(['archive' => true]);

        return redirect()->back()->with('success', 'Dorm archived successfully!');
    }

    public function toggleFavorite($propertyId)
    {
        $userId = auth()->id();

        // Find the dorm with favorite count
        $dorm = Dorm::withCount('favoritedBy')->findOrFail($propertyId);

        // Check if the user already favorited this dorm
        $favorite = Favorite::where('user_id', $userId)->where('dorm_id', $propertyId)->first();

        if ($favorite) {
            // Unfavorite and update favorite count
            $favorite->delete();
            $isFavorited = false;
        } else {
            // Favorite the dorm and update favorite count
            Favorite::create(['user_id' => $userId, 'dorm_id' => $propertyId]);
            $isFavorited = true;
        }

        // Re-fetch the dorm to get updated favorite count
        $dorm->refresh();

        // Return the updated favorite count
        return response()->json([
            'count' => count($dorm->favoritedBy),
            'is_favorited' => $isFavorited
        ]);
    }

    public function trackView($propertyId)
    {
        $userId = auth()->id(); // You can also track views by guests, or use their session ID
        $findUser = PropertyView::where('user_id', $userId)->where('dorm_id', $propertyId)->first();

        // Check if the user hasn't already viewed the property
        if (!$findUser) {
            PropertyView::create([
                'user_id' => $userId,
                'dorm_id' => $propertyId,
            ]);

            return response()->json(['message' => 'Property view tracked.']);
        }

        // If a record exists, you might want to handle this case (optional)
        return response()->json(['message' => 'Property view already exists.']);
    }

    public function favourites()
    {
        $dorms = Dorm::whereHas('favourites', function ($query) {
            $query->where('user_id', auth()->id())->where('availability', false)->where('archive', false)->where('flag', false);
        })->get();

        return view('user-fav', compact('dorms'));
    }

    public function ownerProperty(Request $request)
    {
        $userid = auth()->id();

        // Active Properties
        $properties = Dorm::where('user_id', $userid)
            ->where('archive', 0) // Active properties
            ->orderBy('created_at', 'desc')
            ->withCount('favoritedBy')
            ->paginate(12);

        // If it's an AJAX request, return the appropriate data
        if ($request->ajax()) {
            return response()->json([
                'dorms' => view('partials.property-list', compact('properties'))->render(),
                'pagination' => (string) $properties->links()
            ]);
        }

        return view('manage-listing', compact('properties'));
    }
    public function archivedProperty(Request $request)
    {
        try {
            $userid = auth()->id();

            // Fetch archived properties (archive = 1)
            $properties = Dorm::where('user_id', $userid)
                ->where('archive', 1) // Archived properties
                ->orderBy('created_at', 'desc')
                ->withCount('favoritedBy')
                ->paginate(12);

            // If it's an AJAX request, return the appropriate data
            if ($request->ajax()) {
                return response()->json([
                    'archived_dorms' => view('partials.property-list', compact('properties'))->render(),
                    'archived_pagination' => (string) $properties->links()
                ]);
            }

            // Return the archived properties view
            return view('archived-properties', compact('properties'));

        } catch (\Exception $e) {
            // Log the error
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function restore($id)
    {
        $dorm = Dorm::findOrFail($id);
        $dorm->archive = 0;  // Set to 0 to indicate it's not archived
        $dorm->save();

        return response()->json(['success' => true]);
    }


    public function getUserData($id)
    {
        $user = User::findOrFail($id);
        $reviews = Reviews::where('user_id', $id)->get(); // Fetch all reviews
        if ($user->role == 'owner') {
            // Retrieve all dorms to calculate the average rating for all properties by the owner
            $allDorms = Dorm::where('dorms.user_id', $user->id)
                ->where('flag', 0)
                ->where('archive', 0)
                ->leftJoin('reviews', 'dorms.id', '=', 'reviews.dorm_id')
                ->select('dorms.id', DB::raw('AVG(reviews.rating) as average_rating'))
                ->groupBy('dorms.id')
                ->get();

            // Calculate average rating for all properties (unpaginated)
            $totalRating = $allDorms->sum(fn($property) => $property->average_rating * $property->reviews->count());
            $totalReviews = $allDorms->sum(fn($property) => $property->reviews->count());
            $averageOwnerRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : '0';

            // Now paginate dorms for display
            $dorms = Dorm::select('dorms.id', 'dorms.name', 'dorms.address', 'dorms.image', 'dorms.description', 'dorms.user_id', DB::raw('AVG(reviews.rating) as average_rating'))
                ->where('dorms.user_id', $user->id)
                ->where('dorms.flag', 0)
                ->where('archive', 0)
                ->leftJoin('reviews', 'dorms.id', '=', 'reviews.dorm_id')
                ->groupBy('dorms.id', 'dorms.name', 'dorms.description', 'dorms.address', 'dorms.image', 'dorms.user_id')
                ->orderBy('average_rating', 'desc')
                ->paginate(5);

            // Prepare content with property details
            $content = "<div class='property-list'>";
            $content .= "<h4>Active Properties:</h4>";
            $content .= "<p class='owner-rating'><strong>Owner Rating:</strong> {$averageOwnerRating} / 5 ({$totalReviews} reviews)</p>";
            $content .= "<ul>";

            foreach ($dorms as $property) {
                $fullAddress = $property->address;

                // Shorten the address for display
                $addressParts = explode(',', $fullAddress);
                $shortAddress = implode(', ', array_slice($addressParts, 0, 3));
                $propertyRating = $property->reviews->count() > 0 ? round($property->reviews->avg('rating'), 1) : '0';
                $reviewCount = $property->reviews->count();
                $images = json_decode($property->image, true);
                $firstImage = isset($images[0]) ? 'https://storage.googleapis.com/homeseek-profile-image/' . $images[0] : 'https://via.placeholder.com/80x80';

                $content .= "<li>";
                $content .= "<img src='" . asset($firstImage) . "' alt='Property Image' width='80'>";
                $content .= "<div class='property-details' style='cursor: pointer;' onclick='location.href=\"" . route('dorms.posted', $property->id) . "\"'>";
                $content .= "<h5>{$property->name}</h5>";
                $content .= "<p><strong>Location:</strong> {$shortAddress}</p>";
                $content .= "<p class='rating'><strong>Rating:</strong> {$propertyRating} / 5 ({$reviewCount} reviews)</p>";
                $content .= "</div>";
                $content .= "</li>";
            }

            $content .= '</ul>';
            $content .= '</div>';

            // Add pagination data to the response
            return response()->json([
                'name' => $user->name,
                'role' => ucfirst($user->role),
                'content' => $content,
                'profile_picture' => $user->profile_picture,
                'pagination' => [
                    'total' => $dorms->total(),
                    'per_page' => $dorms->perPage(),
                    'current_page' => $dorms->currentPage(),
                    'last_page' => $dorms->lastPage(),
                ]
            ]);
        } elseif ($user->role == 'tenant') {
            $content = '';
            if (Auth::user()->role == 'admin') {
                // Retrieve the rented property details first
                $rentedProperty = RentForm::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->with('dorm')
                    ->first();

                if ($rentedProperty) {
                    $content .= '<div class="rented-property">';
                    $content .= '<h4>Current Rented Property:</h4>';
                    $content .= '<p><strong>Name:</strong> ' . htmlspecialchars($rentedProperty->dorm->name) . '</p>';
                    $content .= '<p><strong>Address:</strong> ' . htmlspecialchars($rentedProperty->dorm->address) . '</p>';
                    $content .= '</div>';

                    // Retrieve the upcoming bill, assuming it's part of the rented property details
                    $upcomingBill = Billing::where('rent_form_id', $rentedProperty->id)
                        ->where('status', 'pending') // Adjust status as needed
                        ->orderBy('billing_date', 'asc')
                        ->first();

                    if ($upcomingBill) {
                        // Create a DateTime object for the billing date
                        $date = new DateTime($upcomingBill->billing_date);
                        $billingDate = $date->format("M d, Y");

                        // Check if the billing date is in the past
                        $currentDate = new DateTime();
                        $isOverdue = $date < $currentDate; // true if the billing date is in the past

                        // Start the content for the upcoming bill
                        $content .= '<div class="upcoming-bill">';

                        // Display the bill amount
                        $content .= '<h5>Upcoming Bill:</h5>';
                        $content .= '<p><strong>Amount Due:</strong> ₱' . number_format($upcomingBill->amount, 2) . '</p>';

                        // Apply red color for overdue bills
                        $dueDateStyle = $isOverdue ? 'style="color: red;"' : '';  // Apply red text for overdue bills

                        // Display the due date with conditional styling
                        $content .= '<p><strong>Due Date:</strong> <span ' . $dueDateStyle . '>' . $billingDate . '</span></p>';

                        $content .= '</div>';
                    } else {
                        // No upcoming bills for the tenant
                        $content .= '<p>No upcoming bills for this tenant.</p>';
                    }

                } else {
                    $content .= '<p>No rented property found for this tenant.</p>';
                }
            }
            // Now, add the Past Reviews section after rented property
            $content .= '<h4>Past Reviews:</h4><ul>';
            if ($reviews->isEmpty()) {
                $content .= '<li>No reviews available.</li>';
            } else {
                foreach ($reviews as $review) {
                    // Building each review item HTML
                    $content .= '<div class="review-item">';
                    $content .= "<h5 onclick='location.href=\"" . route('dorms.posted', $review->dorm_id) . "\"'>
                                    <strong> <a href='javascript: void(0)'>" . htmlspecialchars($review->dorm->name) . '</a></strong></h5>';
                    $content .= '<p>Located at: ' . htmlspecialchars($review->dorm->address) . '</p>';
                    $content .= '<div class="rating">Rating: ';

                    // Star rating display logic
                    for ($i = 1; $i <= 5; $i++) {
                        $content .= '<span class="star' . ($i <= $review->rating ? ' filled' : '') . '">★</span>';
                    }
                    $content .= '</div>'; // Closing rating div

                    // Additional review details
                    $content .= '<p><strong>Comments:</strong> ' . htmlspecialchars($review->comments) . '</p>';
                    $content .= '<p><small>Reviewed on: ' . htmlspecialchars($review->updated_at->format('Y-m-d H:i')) . '</small></p>';
                    $content .= '</div>'; // Closing review-item div
                }
            }
            $content .= '</ul>';

            return response()->json([
                'name' => $user->name,
                'role' => ucfirst($user->role),
                'content' => $content,
                'profile_picture' => $user->profile_picture
            ]);
        } else {
            $content = '<div class="review-item">';
            $content .= '<p>No additional data available.</p>';
            $content .= '</div>';
            return response()->json([
                'name' => $user->name,
                'role' => ucfirst($user->role),
                'content' => $content,
                'profile_picture' => $user->profile_picture
            ]);
        }


    }
    public function storeReport(Request $request)
    {
        $request->validate([
            'reported_id' => 'required|exists:users,id',
            'type' => 'required|string',
            'Repreason' => 'required|string|max:255',
        ]);

        $report = Reports::create([
            'user_id' => Auth::id(),           // ID of the reporting user
            'reported_id' => $request->reported_id, // ID of the reported user
            'dorm_id' => $request->dorm_id,
            'reported_type' => $request->type,    // ID of the reported property (optional)
            'reason' => $request->Repreason == 'Other' ? $request->otherReason : $request->Repreason,

        ]);

        return response()->json(['message' => 'Report submitted successfully']);
    }


}

