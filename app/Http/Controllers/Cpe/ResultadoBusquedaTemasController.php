<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class ResultadoBusquedaTemasController extends Controller
{
	public function index(Request $request){

	$sterm = $request->input('name');

	$courses = Course::where('name','like','%'.$sterm.'%')->orWhere('goal','like','%'.$sterm.'%')->get();

	return view('cpe.resultado-busqueda-temas',compact('courses','sterm'));

}
}
