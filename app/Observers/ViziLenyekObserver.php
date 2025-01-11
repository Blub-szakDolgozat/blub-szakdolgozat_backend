<?php

namespace App\Observers;

use App\Models\ViziLenyek;
use Illuminate\Support\Facades\Log;

//itt kezeljük a modell eseményeit, ez egy dedikált osztály
// Akkor kel használni, ha egy modellt érintő műveleteknél ismétlődő műveleteket kell végrehajtani
class ViziLenyekObserver
{

    /**
     * Handle the ViziLenyek "created" event.
     */
    public function created(ViziLenyek $viziLenyek): void
    {
        //
    }

    /**
     * Handle the ViziLenyek "updated" event.
     */
    public function updated(ViziLenyek $viziLenyek): void
    {
        Log::info('A vízi lény neve frissítve lett: ' . $viziLenyek->nev . ' új név: ' . $viziLenyek->getOriginal('nev'));

    }

    /**
     * Handle the ViziLenyek "deleted" event.
     */
    public function deleted(ViziLenyek $viziLenyek): void
    {
        //
    }

    /**
     * Handle the ViziLenyek "restored" event.
     */
    public function restored(ViziLenyek $viziLenyek): void
    {
        //
    }

    /**
     * Handle the ViziLenyek "force deleted" event.
     */
    public function forceDeleted(ViziLenyek $viziLenyek): void
    {
        //
    }
}
