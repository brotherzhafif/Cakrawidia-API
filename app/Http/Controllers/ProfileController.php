<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed'
        ]);

        // Update username jika disediakan
        if ($request->has('username')) {
            $user->username = $request->username;
        }

        // Update email jika disediakan
        if ($request->has('email')) {
            $user->email = $request->email;
            $user->email_verified_at = null; // Reset verifikasi email
        }

        // Update password jika disediakan
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Delete the authenticated user's account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Validasi password
        $request->validate([
            'password' => 'required'
        ]);

        // Periksa password
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password yang Anda masukkan salah.']
            ]);
        }

        // Logout dan hapus akun
        Auth::logout();
        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully'
        ]);
    }
}