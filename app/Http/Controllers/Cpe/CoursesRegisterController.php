<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoursesUser;
use App\Models\CourseSchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CoursesRegisterController extends Controller
{
    public function index(){
        
        if(!isset($_GET['prog'])){
            
            abort(403);
        
        }
        
        $schedule = checkVar($_GET['prog'],'CourseSchedule');
        
        
        if($revision = checkInscripcion()){
            $message = '<h5>Ya te encuentras inscrito a un ciclo de retos.<br /> Intenta nuevamente una vez lo hayas culminado</h5>';
            return redirect()->route('ciclos-retos.index')->with('message',$message)->with('error','El usuario tiene un ciclo de retos programado o activo');
        }
        

		else{
			
            $register = new CoursesUser;

            $register->course_name = $schedule->course->name;

            $register->user_id = auth()->id();

            $register->course_schedule_id = $schedule->id;

            $register->actual_challenge = 0;
            
            $register->alert_messages = 'email';
            
            $register->whatsapp_user = 0;
            
            $register->status = 'Inscrito';

            if($register->save()){
                
                $formAction = route("cpe.preferencias-ciclo.guardarPreferencias");
                $csrf = csrf_token();

                $message = '<form action="'.$formAction.'" method="post"><p><strong>Tu inscripción para el ciclo de retos está casi completa</strong>.<br />Inicio: '.fechaEs($schedule->start_date).'</p><p>Elige <strong>por dónde quieres responder los retos</strong>, puedes hacerlo a través de mensajes por WhatsApp o responderlos en la web (por esta página).</span><p>Recuerda que <strong><u>no vas a poder cambiarlo</u></strong> y tendrás que terminar el ciclo de retos por el medio que elijas</p><div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="whatsapp_user_1" name="whatsapp_user" value="1" required>
                        <label class="form-check-label" for="whatsapp_user_1"> Responder por WhatsApp</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="whatsapp_user_2" name="whatsapp_user" value="0" required>
                        <label class="form-check-label" for="whatsapp_user_1"> Responder por la Web</label>
                    </div>
                </div>
                <p>Elige <strong>por dónde quieres recibir los recordatorios</strong> para responder cada reto:</p>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="alert_messages_1" name="alert_messages" value="email" required>
                        <label class="form-check-label" for="whatsapp_user_1">Por Correo electrónico</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" id="alert_messages_2" name="alert_messages" value="sms" required>
                        <label class="form-check-label" for="whatsapp_user_1">Por mensajes de texto</label>
                    </div>
                </div>
                <input type="hidden" name="inscripcion" value="'.$register->id.'">
                <input type="hidden" name="_token" value="'.$csrf.'"> 
                <div style="float:right"><button type="submit" class="btn-gen">Enviar preferencias</button></div>
                </form>';

                return redirect()->route('ciclos-retos.index')->with('message',$message);
            }
            else{

                $message = '<h3>Ocurrio un error en el proceso de inscripción. Comuniquese con soporte</h3>';

                return redirect()->route('ciclos-retos.index')->with('message',$message)->with('error', 'Usuario no se puede registrar');
            }
        }
    }
}
	
