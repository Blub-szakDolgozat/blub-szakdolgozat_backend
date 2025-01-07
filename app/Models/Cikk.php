<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cikk extends Model

{
    use HasFactory;
    protected $primaryKey = "cikk_id";
        
    protected $fillable = [
        'cim',
        'kepek',
        'leiras',
        'publikalva'
    ];

}
