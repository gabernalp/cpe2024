<?php

namespace App\Http\Controllers\Cpe;

use App\Models\BackgroundProcess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class BackgroundProcessController extends Controller
{
    public function index()
    {

        $background_processes = BackgroundProcess::all()->pluck('name', 'id');
        
        return view('cpe.ciclos-retos', compact('background_processes'));

    }

}
