<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cikk extends Model
{
    protected $fillable = [
        'cikk_id',
        'cim',
        'kepek',
        'leiras',
        'publikalva',
    ];

}
