<?php

namespace App\Http\Controllers\comunes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class comunesController extends Controller
{
    public function volver(){
        
        return redirect()->back();

    }
}
