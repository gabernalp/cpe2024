<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventsSchedule;

class IncomingEventsController extends Controller
{
    public function index(){
		
		$events = EventsSchedule::where('date','>',date("Y-m-d"))->get();
		
		return view('cpe.eventos-institucionales',compact('events'));
		
	}
}
