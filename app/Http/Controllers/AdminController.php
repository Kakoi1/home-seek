<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {
        $usersCount = \App\Models\User::count();

        // Count of property owners (assuming 'role' or 'is_owner' field indicates a property owner)
        $ownersCount = \App\Models\User::where('role', 'owner')->count();

        // Count of listed properties
        $propertiesCount = \App\Models\Dorm::count(); // Assuming Dorm model handles property listings

        // Pass the data to the view
        return view('admin.dashboard', compact('usersCount', 'ownersCount', 'propertiesCount'));

    }

    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manageuser', compact('users'));
    }

    public function approveDorm(Request $request)
    {
        // Logic for approving dorms
    }

    public function deleteDorm($id)
    {
        // Logic for deleting dorms
    }
}

