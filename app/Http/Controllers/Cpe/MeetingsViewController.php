<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meeting;

class MeetingsViewController extends Controller
{
    public function index(){
		
		$meetings = Meeting::where('date','>=',date("Y-m-d"))->orderBy('date','ASC')->take(3)->get();
		
		return view('cpe.encuentros-practica',compact('meetings'));
		
	}
}
