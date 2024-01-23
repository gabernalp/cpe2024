<?php

function getSftp(){

	return env('FTP_HOST');
	
}

//Validación para todos los objetos segun id enviado
function checkVar($checkId,$checkObject){
    
    $pref = 'App\Models';
    $model = $pref."\\".$checkObject;
        
    if(($elements = $model::find($checkId)) == null){
        
        abort(403);
        
    }
    else{
        
        return $elements;
        
    }

}

//Validacion de tipo de ciclo de retos tematica no especial

function checkTipoCiclo($tipoCiclo){
    
    if(($tipoCiclo == 1) || ($tipoCiclo == 3) || (($tipoCiclo == 6))){
        
        return $tipoCiclo;
    
    }
    else{
        
        abort(403);
        
    }
    
}

function fechaEs($fecha) {
    
    $fecha = substr($fecha, 0, 10);
    
    $numeroDia = date('d', strtotime($fecha));
    
    $dia = date('l', strtotime($fecha));
    
    $mes = date('F', strtotime($fecha));
    
    $anio = date('Y', strtotime($fecha));
    
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    
    return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
    
}

function fechaEsNoDay($fecha) {
    
    $fecha = substr($fecha, 0, 10);
    
    $numeroDia = date('d', strtotime($fecha));
    
    $dia = date('l', strtotime($fecha));
    
    $mes = date('F', strtotime($fecha));
    
    $anio = date('Y', strtotime($fecha));
    
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    
    return $numeroDia." de ".$nombreMes." de ".$anio;
    
}

function checkInscripcion(){
    
    if($inscripcion = App\Models\CoursesUser::where('user_id',auth()->id())->where('actual_challenge','<',7)->first()){
        
        return true;
        
    }    
    
}
function getPassword($password){
	
	$obj = new DOTNET("MiDLL, Version=1.0.0.0, Culture=neutral, PublickeyToken=57d5b52865489ba5", "MiDLL.Encriptor");
    $respuesta = $obj->Encrypt($password,"llaveseguridadMTS2017");
	return $respuesta;
	
}

function validateExternal(){
    
    $external = true;
    
    if(auth()->user()->hasRole('Usuario Externo')){
        
        $numRoles = App\Models\User::find(auth()->id())->roles()->get()->count();
        
        if(auth()->user()->hasRole('Coordinador')){
                
                $numRoles = $numRoles-1;
        }
        
        if($numRoles > 1){

            $external = false;
            
        }
        
    }
    else{
        
        $external = false;
    }

    return $external;
}
function validateInternal(){
    
    $internal = true;
    
    if(auth()->user()->hasRole('Usuario Externo')){
        
        $internal = false;
    }
    
    return $internal;
}