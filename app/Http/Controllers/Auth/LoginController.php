<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
     /**
     * Mutatja a bejelentkezési űrlapot.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Kezeli a bejelentkezést.
     */
    public function login(Request $request)
    {
        // Validáció
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Hitelesítési próbálkozás
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Hitelesítés sikeres
            return redirect()->intended('/home')->with('success', 'Sikeresen bejelentkeztél!');
        }

        // Hitelesítés sikertelen
        return back()->withErrors([
            'email' => 'Helytelen hitelesítési adatok.',
        ]);
    }

    /**
     * Kezeli a kijelentkezést.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Sikeresen kijelentkeztél!');
    }
    protected function authenticated(Request $request, $user)
{
    $user->update(['last_login_at' => now()]);
}

}
