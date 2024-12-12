<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            // Coba invalidate token sebelumnya jika ada
            $existingToken = JWTAuth::getToken();
            if ($existingToken) {
                try {
                    JWTAuth::invalidate($existingToken);
                } catch (JWTException $e) {
                    // Abaikan jika token sudah tidak valid
                }
            }

            // Buat token baru
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
    
            $user = auth()->user();
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Could not create token', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy(Request $request)
    {
        try {
            // Invalidate semua token yang aktif
            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
            }

            // Tambahan: Logout dari semua device
            $user = JWTAuth::parseToken()->authenticate();
            JWTAuth::factory()->setTTL(0); // Set time to live menjadi 0
            
            return response()->json(['message' => 'Logged out successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Could not logout', 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}