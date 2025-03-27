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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
    }

    public function getUser($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Felhasználó nem található'], 404);
    }

    return response()->json([
        'message' => 'Sikeres adatlekérés.',
        'user' => $user
    ]);
}

    



    // app/Http/Controllers/UserController.php

    public function update(Request $request, $userId)
    {
        // Felhasználó keresése az id alapján
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Az új adatok validálása
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:8',
            'profilkep' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Az adatok frissítése
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('profilkep')) {
            $image = $request->file('profilkep');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile_pics'), $imageName);
            $user->profilkep = url('uploads/profile_pics/' . $imageName); // 🔹 Elmentjük az URL-t
        }

        // Mentés
        $user->save();

        return response()->json(['user' => $user]);
    }







    //nem alap lekérdezések

    function userLendings()
    {
        $user = Auth::user();
        return User::with('userandlendingsdata')
            ->where('id', '=', $user->id)
            ->get();
    }

    public function usersWithReservations()
    {
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
    public function regisztralasiSorrend()
    {
        $felhasznalok = DB::table('users')
            ->select('name', 'email', 'regisztracio_datum')
            ->orderByDesc('regisztracio_datum')
            ->get();

        return $felhasznalok;
    }

    public function updateUsername(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        $user = User::find($id);
        $user->name = $request->username;
        $user->save();

        return response()->json([
            'message' => 'Felhasználónév frissítve.',
            'user' => $user,
        ]);
    }

    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::find($id);
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Email cím frissítve.',
            'user' => $user,
        ]);
    }

    public function updateProfilePic(Request $request, $id)
    {
        $request->validate([
            'profilkep' => 'required|url',
        ]);

        $user = User::find($id);
        $user->profilkep = $request->profilkep;
        $user->save();

        return response()->json([
            'message' => 'Profilkép frissítve.',
            'user' => $user,
        ]);
    }
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed', // új jelszó + megerősítés
    ]);

    $user = auth()->user();

    // Ellenőrizzük, hogy a jelenlegi jelszó helyes-e
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['message' => 'A jelenlegi jelszó hibás.'], 400);
    }

    // Jelszó frissítése
    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Jelszó sikeresen frissítve.']);
}
}
