<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoursesUser;
use App\Models\ChallengesUser;
use App\Models\Challenge;

use Illuminate\Http\Response;

class CourseShowController extends Controller
{
    public function index(){
        
        if(!isset($_GET['ciclo'])){
            abort(403);
        }
		
        $courseUser = $_GET['ciclo'];
		if(!$course = CoursesUser::find($courseUser)){
            abort(404);
        }
        else{
            
		  if($course->user_id != auth()->id()){
              return new Response('<h1>Acceso no autorizado<h1>', 403);
          }
            else{
                $completed = Challenge::where('course_id',$course->course_schedule->course->id)->get();
                $challengesCount = ChallengesUser::where('user_id',auth()->id())->where('courseschedule_id',$course->course_schedule_id)->get();
                return view('cpe.mostrar-ciclo', compact('course','completed','challengesCount'));
            }
        }
	}
}
