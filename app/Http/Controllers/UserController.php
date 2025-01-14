<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new User();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
    }

    //nem alap lekérdezések
    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "jelszo" => 'string|min:3|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
        $user = User::where("id", $id)->update([
            "jelszo" => Hash::make($request->password),
        ]);
        return response()->json(["user" => $user]);
    }

    function userLendings(){
        $user=Auth::user();
        return User::with('userandlendingsdata')
        ->where('id','=', $user->id)
        ->get();
    }

    public function usersWithReservations(){
        return User::with('usersAndReservations')
        ->get();
    }


    //Regisztrálás
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'felhasznalonev' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'jelszo' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'felhasznalonev' => $request->name,
            'email' => $request->email,
            'jelszo' => Hash::make($request->password), // A jelszó titkosítása
        ]);

        return response()->json([
            'message' => 'Sikeres regisztráció!',
            'user' => $user
        ], 201);
    }
    //Bejelentkezés
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'jelszo' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if (Auth::attempt([
            'email' => $request->email,
            'jelszo' => $request->password,
        ])) {

            $user = Auth::user();
            return response()->json([
                'message' => 'Sikeres bejelentkezés!',
                'user' => $user,
                'token' => $user->createToken('API Token')->plainTextToken
            ]);
        }

        return response()->json(['message' => 'Hibás email vagy jelszó!'], 401);
    }
    //Profil megtekintés
    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Nem vagy bejelentkezve.'], 401);
        }
        
        return response()->json([
            'message' => 'Sikeres lekérés.',
            'user' => $user,
        ]);
    }


}
