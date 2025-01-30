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

    public function getUser() {
        $user = auth()->user();
        return response()->json($user);  // A válaszban küldd vissza az összes szükséges adatot, beleértve a 'jogosultsagi_szint' értéket is
    }
    
    

    //nem alap lekérdezések
    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "password" => 'string|min:3|max:50'
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->all()], 400);
        }
        $user = User::where("id", $id)->update([
            "password" => Hash::make($request->jelszo),
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
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
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
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

    
    //  7.	Felhasználók regisztrálási sorrendje:
    public function regisztralasiSorrend(){
        $felhasznalok = DB::table('users') 
        ->select('name', 'email', 'regisztracio_datum')
        ->orderByDesc('regisztracio_datum') 
        ->get();

        return $felhasznalok;
    }
}
