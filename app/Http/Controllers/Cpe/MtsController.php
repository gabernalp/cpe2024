<?php

namespace App\Http\Controllers\Cpe;

use App\Models\BackgroundProcess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;
use Auth;
use App\Models\User;


class MtsController extends Controller
{
    public function index(){

        return view('auth.gestion');

    }

    public function validateMts(Request $request)
    {

	    try{

            $respuesta = getPassword($request->input('password'));
            $usuario = $request->input('username');
            $client = new Client();
            $line = env("MTS_ROOT").$usuario.'/Contrasenia/'.$respuesta.'/CodAplicacion/20';
            $requestMts = $client->request('GET', $line,['verify' => false,'connect_timeout' => 60]);
            $response = $requestMts->getBody();
            $obj = json_decode($response);
            if($syncUser = User::where('document',$obj->numeroDocumento)->first()){
                $syncUser->password = bcrypt($request->input('password'));
                $syncUser->save();
            }
            else{
                return redirect()->route('cpe.gestion')->with('error','error')->with('message','Usuario MTS correcto, el documento No. <b>'.$obj->numeroDocumento.'</b> no se encuentra registrada en la aplicación');
            }
            if($resultado = Auth::attempt(['document' => $obj->numeroDocumento, 'password' => $request->input('password')], true)){

                session(['mts' => auth()->id()]);
                return redirect()->route('admin.home');
        
            }
            else{

                return redirect()->route('cpe.gestion')->with('error','error')->with('message','Error en autenticación interna. Credenciales no autorizadas en la aplicación');
            }
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {

            if ($e->hasResponse()) {

                $response = $e->getResponse();
                return redirect()->route('cpe.gestion')->with('error','error')->with('message','Error en autenticación de MTS. Credenciales no autorizadas, Intente nuevamente');
           
            }
        }

    }

}
