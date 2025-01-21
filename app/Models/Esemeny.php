<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esemeny extends Model
{
    /** @use HasFactory<\Database\Factories\EsemenyFactory> */
    use HasFactory;

    protected $fillable = [
        'esemeny_neve',
        'leiras',
        'datum',
        'helyszin',
        'letszam'
    ];
}
