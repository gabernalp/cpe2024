<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoursesUser;

class CoursesPreferencesController extends Controller
{
    public function guardarPreferencias(Request $request){
        
        $preferencesUser = CoursesUser::find($request->input('inscripcion'));
        
        $dateSchedule = $preferencesUser->course_schedule->start_date;
        
        $preferencesUser->whatsapp_user = $request->input('whatsapp_user');
        
        $preferencesUser->alert_messages = $request->input('alert_messages');
        
        if($preferencesUser->save()){
            
            $message = '<h3>Inscripción completada exitosamente.</h3><p>Inicio del ciclo: '.fechaEs($dateSchedule).'</p><div style="float:right"><a href="/mi-perfil" class="btn btn-primary">Ir a mi perfil</a></div>';
            
            return redirect()->route('ciclos-retos.index')->with('message',$message);
            
        }
        else{
            
            $message = '<h3>No se pudo solicitar su solicitud, intente nuevamente</h3>';
            
            return redirect()->route('ciclos-retos.index')->with('message',$message)->with('error','error');

        }
        
    }

}
