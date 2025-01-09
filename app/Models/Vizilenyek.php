<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vizilenyek extends Model
{
    use HasFactory;
    protected $fillable = [
        'nev', 'fajta','ritkasagi_szint','leiras', 'kep'
    ];

    public function akvariumok()
    {
        return $this->hasMany(Akvarium::class, 'vizi_leny_id');
    }
}
