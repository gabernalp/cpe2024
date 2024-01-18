<?php

namespace App\Http\Controllers\Cpe;

use App\Models\CoursesHook;
use App\Models\Department;
use App\Models\City;
use App\Models\DocumentType;
use App\Models\Profile;
use App\Models\Entity;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSelfInterestedUserRequest;
use App\Models\SelfInterestedUser;
use Illuminate\Http\Request;


class CoursesHookViewController extends Controller
{
    public function index(){

        $departments = Department::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');
        
        $profiles = Profile::where('entidad_asociada_id',1)->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');
        
        $entidad_asociadas = Entity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $banners = Banner::where('position',1)->get();

        return view('cpe.ofertas-formacion', compact('departments','profiles','entidad_asociadas','banners'));

    }

    public function search(Request $request){
        
        try{
        
            if($request->input('entidad_asociada_id')){

                if($request->input('profile_id')){

                    $departments = Department::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');

                    $documenttypes = DocumentType::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');

                    $profile = Profile::find($request->input('profile_id'));

                    return view('cpe.resultadoOfertasIcbf',compact('profile','documenttypes','departments'));

                }
                else{

                    $results = CoursesHook::where('entidad_id','>',1)->inRandomOrder()->take(20)->get();

                    return view('cpe.resultadoOfertas',compact('results'));

                }

            }
        }
        catch (Throwable $e) {
            if(report($e)){
                abort(403);
            }
            return false;
    }
        

        
        
    }
    
    public function store(StoreSelfInterestedUserRequest $request){
        
        if(SelfInterestedUser::where('documenttype_id',$request->input('documenttype_id'))->where('document',trim($request->input('document')))->whereNull('deleted_at')->exists()){
        
            $message = 'Ya tienes una solicitud registrada previamente.<br />Puedes consultar el estado del proceso <a href="/ofertas-formacion">haciendo clic aqui</a>';
            
            $error = 'Usuario con registro de ofertas activo';
            
        }
        else{
            
            $selfInterestedUser = SelfInterestedUser::create($request->all());

            $selfInterestedUser->courseshooks()->sync($request->input('courseshooks', []));

            $message = 'Quedaste preinscrito en las ofertas seleccionadas, verificaremos tus datos y acorde con la disponibilidad de los cupos te estaremos contactando a través de correo o telefónicamente para formalizar tu<br />inscripción. Puedes consultar el estado del proceso en este portal haciendo <a href="/linea-tiempo-ofertas">clic aqui</a>';
            
            $error = '';
        
        }
                    
        $departments = Department::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');

        $profiles = Profile::all()->pluck('name','id')->prepend(trans('global.pleaseSelect'), '');

        $entidad_asociadas = Entity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        return redirect()->route('ofertas-formacion.index')->with('message',$message)->with('error',$error);

    
    }


}
