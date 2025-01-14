<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
                'regi_jelszo' => ['required', 'string'],
            ]);
    if (!Auth::attempt($request->only('email', 'regi_jelszo'))) {
                return response()->json(['message' => 'Invalid login credentials'], 401);        }
            $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'status' => 'Login successful',
            ]);
    
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
{
    	$request->user()->currentAccessToken()->delete();
    	return response()->json(['message' => 'Logout successful']);
}

}
