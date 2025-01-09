<?php

namespace App\Http\Controllers;

use App\Models\Vizilenyek;
use Illuminate\Http\Request;

class VizilenyekController extends Controller
{
    public function index()
    {
        return Vizilenyek::all();
    }
}
