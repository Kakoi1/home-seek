<?php
namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'rooms_available' => 'required|integer',
            'price' => 'required|numeric',
            'type' => 'required|string',
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
            'rooms_available' => $request->rooms_available,
            'price' => $request->price,
            'image' => $imaging,
            'type' => $request->type,
        ]);

        for ($i = 1; $i <= $request->rooms_available; $i++) {
            Room::create([
                'dorm_id' => $dorm->id,
                'number' => 'Room ' . $i,
                'capacity' => null,
                'price' => null,
                'status' => true, // Set to available by default
            ]);
        }

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

        // Paginate results
        $dorms = $query->paginate(10);

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
        return view('dorms.adddorm', compact('dorm'));
    }
    public function show($id)
    {
        $dorm = Dorm::with('user')->findOrFail($id);
        return view('dorms.posted', compact('dorm'));
    }

    public function archive($id)
    {
        $dorm = Dorm::findOrFail($id);
        $dorm->update(['archive' => true]);

        return redirect()->back()->with('success', 'Dorm archived successfully!');
    }


}

