<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akvarium extends Model
{
    use HasFactory;

    public function viziLenyek()
    {
        return $this->belongsTo(ViziLenyek::class, 'vizi_leny_id');
    }
}
