<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseSchedule;
use App\Models\Course;


class CoursesDetailController extends Controller
{
    public function index(){
        
        if(!isset($_GET['ciclo'])){
            
            abort(403);
        
        }
		
		$ciclo = checkVar($_GET['ciclo'],'Course');
        
        $aleatorios = Course::join('course_schedules','courses.id','=','course_schedules.course_id')->where('courses.id','<>',$ciclo->id)->where('start_date','>',date("Y-m-d"))->where('course_schedules.deleted_at',null)->take(2)->inRandomOrder()->get();
        
		$programaciones =  CourseSchedule::where('course_id',$ciclo->id)->where('start_date','>',date("Y-m-d"))->get();
        
		return view('cpe.detalle-ciclo', compact('programaciones','ciclo','aleatorios'));
	}
}
