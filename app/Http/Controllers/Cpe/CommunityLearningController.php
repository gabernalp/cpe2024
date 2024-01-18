<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunityLearningController extends Controller
{
    public function index(){
		
		return view('cpe.eventos-encuentros');
	}
}
