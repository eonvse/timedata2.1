<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Color;

class ColorController extends Controller
{

    public function index()
    {
        $colors = Color::where('id','>',1)->get();
 
        return view('colors', compact('colors'));
    }
 
}
