<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\AuditLog;
use App\Models\Course;

class UniqueChallengesController extends Controller
{
    public function index(){
        
        if(!isset($_GET['ciclo'])){
            
            abort(403);
        
        }
        
        $ciclo = checkVar($_GET['ciclo'],'Course');
        
        AuditLog::create([
            'description'  => 'audit:read',
            'subject_id'   => $ciclo->id,
            'subject_type' => 'App\Models\Course#'.$ciclo->id,
            'user_id'      => auth()->id() ?? null,
            'properties'   => date("Y-m-d H:i:s"),
            'host'         => request()->ip() ?? null,
        ]);
        
        $challenge = Challenge::where('course_id',$ciclo->id)->orderBy('id','ASC')->first();
        
        $aleatorios = Course::join('course_schedules','courses.id','=','course_schedules.course_id')->where('courses.id','<>',$ciclo->id)->where('start_date','>',date("Y-m-d"))->where('course_schedules.deleted_at',null)->take(2)->inRandomOrder()->get();
        
        return view('cpe.reto-unico', compact('challenge','aleatorios'));

    }
}
