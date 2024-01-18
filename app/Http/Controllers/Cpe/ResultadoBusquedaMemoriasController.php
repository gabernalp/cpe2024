<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventsSchedule;

class ResultadoBusquedaMemoriasController extends Controller
{
	public function index(Request $request){

	$sterm = $request->input('name');

	$memories = EventsSchedule::where('title','like','%'.$sterm.'%')->orWhere('description','like','%'.$sterm.'%')->orWhere('invitados','like','%'.$sterm.'%')->get();

	return view('cpe.resultado-busqueda-memorias',compact('memories','sterm'));

	}
}
