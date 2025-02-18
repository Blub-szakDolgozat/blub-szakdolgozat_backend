<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feliratkozas extends Model
{
    /** @use HasFactory<\Database\Factories\FeliratkozasFactory> */
    use HasFactory;

    protected $primaryKey = ['felhasznalo', 'esemeny'];

    protected $fillable = [
        'felhasznalo', 
        'esemeny', 
        'feliratkozas_datuma',
    ];
    
}
