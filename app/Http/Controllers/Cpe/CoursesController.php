<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackgroundProcess;
use App\Models\Course;
use App\Models\CourseSchedule;
use Carbon\Carbon;

class CoursesController extends Controller
{
	public function index()
    {
                
        // tipo 1 es único, tipo 3 o 6 para caracterizar cantidad de retos del ciclo y frecuencia de envio de mensajes
        // la temática se puede caracterizar como temática especial que genera una diferencia en la forma de presentación de los ciclos de retos}
        
        if((!isset($_GET['tema'])) or (!isset($_GET['tipo']))){
			
			abort(403);
		}
        
        $tipo = checkTipoCiclo($_GET['tipo']);
        
        $tematica = checkVar($_GET['tema'],'BackgroundProcess');
                
        $dateNow = date("Y-m-d");
        
        if($tematica->especial == true){
            
            $ciclosTema = Course::where('tematica_asociada_id',$tematica->id)->orderBy('id','ASC')->get();
            
            $ciclos = Course::join('course_schedules','courses.id','=','course_schedules.course_id')->where('start_date','>',date("Y-m-d"))->where('tematica_asociada_id',$tematica->id)->where('course_schedules.deleted_at',null)->get();
                                    
            return view('cpe.ciclos-de-retos-especiales', compact('tematica','ciclos','ciclosTema'));

        }
        else{
            
            if($tipo == 1){

                $ciclos = Course::where('unico',1)->where('tematica_asociada_id',$tematica->id)->get(); 

                $ciclosTema = Course::where('unico',1)->where('tematica_asociada_id',$tematica->id)->get(); 

            }
            else{
                
            $ciclosTema = Course::where('tematica_asociada_id',$tematica->id)->where('tipo_ciclo',$tipo)->get();


            $ciclos = Course::join('course_schedules','courses.id','=','course_schedules.course_id')->where('start_date','>',date("Y-m-d"))->where('tematica_asociada_id',$tematica->id)->where('tipo_ciclo',$tipo)->where('course_schedules.deleted_at',null)->get();
        
            }
                 
        return view('cpe.ciclos-de-retos', compact('tematica','ciclos','tipo','ciclosTema'));
            
        }
    
    }
		
}
