<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show the authenticated user's profile
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    // Update the authenticated user's profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        // Update the authenticated user's profile information
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }

    // Admin function to show all users
    public function index()
    {
        // Fetch all users for management (only accessible by admin)
        $users = User::all();
        return view('users.index', compact('users')); // Pass users to the view
    }

    // Admin function to show a single user for editing
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user')); // Show the user details in the edit form
    }

    // Admin function to update any user's profile
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users.index')->with('message', 'User updated successfully');
    }

    // Admin function to delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('message', 'User deleted successfully');
    }
}
