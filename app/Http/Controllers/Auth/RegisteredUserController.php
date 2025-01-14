<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'felhasznalonev' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'regi_jelszo' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'felhasznalonev' => $request->name,
            'email' => $request->email,
            'regi_jelszo' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        
        $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->only(['id', 'name', 'email']),
]);


        Auth::login($user);

        return response()->noContent();
    }
}
