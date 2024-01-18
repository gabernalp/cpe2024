<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    public function index (){
        
        if('57'.auth()->user()->document == auth()->user()->phone){
            
            $message = '<h5><i class="fa fa-warning"></i> Eres un usuario previamente registrado en WhatsApp.<br /><br />Es <strong>muy importante que actualices</strong> tus datos, en especial los de <strong> número de documento y correo electrónico</strong> para que puedas aprovechar al máximo las funciones de la plataforma. <br /><br />Recuerda que cuando vuelvas a ingresar, <strong style="colormain">tu usuario será el número de cédula que actualices y tu contraseña la que elijas</strong></h5>';
        }
        else{
            
            $message = '';
        }
            
        return view('auth.edit', compact('message'));
    }
}
