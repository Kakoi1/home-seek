<?php
namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Room;
use App\Models\Favorite;
use App\Models\PropertyView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use User;

class DormController extends Controller
{
    public function saveDorm(Request $request)
    {
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

        $imagePaths = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/dorm_pictures', $filename);
                $imagePaths[] = $filename;
            }
        }
        $imaging = json_encode($imagePaths);

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



        return redirect()->back()->with('success', 'Dorm added successfully!');
    }
    public function showDorms()
    {
        $dorms = Dorm::all();
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

        $dorm = Dorm::with('user')->findOrFail($id);
        $rooms = Room::where('dorm_id', $dorm->id)->count();

        $propertyReview = Dorm::with('reviews')->findOrFail($id);

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
        } else {

        }
        return view('dorms.posted', compact('dorm', 'rooms', 'propertyReview'));
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
        $properties = Dorm::where('user_id', $userid)
            ->where('archive', 0)
            ->orderBy('created_at', 'desc')
            ->withCount('favoritedBy')
            ->paginate(12); // Adjust the number as needed

        if ($request->ajax()) {
            return response()->json([
                'dorms' => view('partials.property-list', compact('properties'))->render(),
                'pagination' => (string) $properties->links()
            ]);
        }

        return view('manage-listing', compact('properties'));
    }


}

