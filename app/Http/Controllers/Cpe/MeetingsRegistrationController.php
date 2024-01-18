<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeetingAttendant;
use App\Models\UserAlert;
use App\Models\Meeting;

class MeetingsRegistrationController extends Controller
{
    public function index(){
        
        if((!isset($_GET['encuentro'])) or (!Meeting::find($_GET['encuentro']))){
			
			abort(403);
		}
		
		$encuentro = $_GET['encuentro'];
        
        if(MeetingAttendant::where('meeting_id',$encuentro)->where('user_id',auth()->id())->get()->count() < 1){
                
            $registrado = new MeetingAttendant;
            
			$registrado->meeting_id = $encuentro;
            
			$registrado->user_id = auth()->id();
            
			$registrado->save();
                
            $message = '<p><strong>¡Has quedado inscrito en el encuentro!</strong><br />Recuerda que será confirmado cuando tenga mínimo 3 inscritos y entonces podrás acceder a la videollamada desde “tu perfil”.</p>';
                
            $error = '';
            
            $share = 'share';

        }
        else{
                
            $message = '<p>Ya te encuentras inscrito en este encuentro</p>';
                
            $error = 'Usuario ya registrado en el encuentro solicitado';
            
            $share = '';
                
        }
            
        $registros = MeetingAttendant::where('meeting_id',$encuentro)->get()->count();
                
        if ($registros == env('REGISTER_MEETING_MIN_USER')){
            
            $userAlert = UserAlert::create(['alert_text' => 'Encuentro para generar link','alert_link' => env('APP_URL').'/admin/meetings/'.$encuentro.'/edit']);
                
            $userAlert->users()->sync([1]);
        
        }

        return redirect()->route('encuentros-practica.index')->with('message',$message)->with('error',$error)->with('share',$share);
    }
}