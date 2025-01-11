<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

//itt kezeljük a modell eseményeit, ez egy dedikált osztály
// Akkor kel használni, ha egy modellt érintő műveleteknél ismétlődő műveleteket kell végrehajtani
class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('last_login_at')) {
            // Naplózás
            Log::info("Felhasználó bejelentkezett: {$user->email} időpont: {$user->last_login_at}");

            // További tevékenységek (pl. értesítés küldése)
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
