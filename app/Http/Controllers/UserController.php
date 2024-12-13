<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Get all users
    public function index(Request $request)
    {
        $limit = $request->input('limit', 5); // Default 5 users
        $users = User::with(['questions', 'answers']) // Load related questions and answers if needed
            ->limit($limit)
            ->latest() // Urutkan dari yang terbaru
            ->get();
        
        return response()->json($users);
    }

    // Get a single user
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // Create a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users,username|max:255',
            'email' => 'required|unique:users,email|email|max:255',
            'password' => 'required|min:6',
            'role' => 'in:user,admin,anonymous',
        ]);

        $validated['password'] = Hash::make($validated['password']); // Hash password

        $user = User::create($validated);
        return response()->json($user, 201);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya user yang bersangkutan yang bisa update
        if ($user->id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'username' => 'unique:users,username|max:255',
            'email' => 'unique:users,email|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Pastikan hanya user yang bersangkutan yang bisa hapus
        if ($user->id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
