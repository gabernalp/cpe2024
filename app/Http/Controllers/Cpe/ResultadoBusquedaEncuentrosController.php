<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meeting;

class ResultadoBusquedaEncuentrosController extends Controller
{
    public function index(Request $request){

	$sterm = $request->input('name');

	$meetings = Meeting::where('title','like','%'.$sterm.'%')->orWhere('description','like','%'.$sterm.'%')->where('date','>=',date("Y-m-d"))->get();

	return view('cpe.resultado-busqueda-encuentros',compact('meetings','sterm'));
		
	}
}
