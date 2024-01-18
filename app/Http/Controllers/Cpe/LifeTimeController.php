<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LifeTimeController extends Controller
{
    public function index (){
            
        return view('cpe.linea-tiempo-ofertas');
    }
}
