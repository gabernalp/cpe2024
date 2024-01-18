@extends('layouts.cpe')
@section('content')
<div id="tipoCiclos" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="row m-0 pt-4 pr-4 pl-4">
			<div class="col-md-12">
				<h1 class="text-center">Tipos de ciclos de retos</h1>
				<p class="pt-4">Te ofrecemos <strong>3 tipos de ciclos de retos</strong>, puedes seleccionar el que más se adecue a tus tiempos y tus intereses. Conoce en qué consiste cada uno acá:</p>
			</div>
		</div>
		<div class="row pr-4 pl-4">
			<div class="col-md-4 text-center p-3"><p class="pl-2 pr-2"><img src="images/1point.png" class="img-fluid" style="max-width:160px"></p><p><strong>Reto único</strong><br /><span style="color:#00528D">(Sólo 1 reto abierto)</span></p><p>Es un ejercicio que vas a recibir inmediatamente, va a contener una cápsula de conocimiento y una actividad sugerida para que reflexiones, aprendas y pongas en práctica conceptos importantes para la primera infancia.</p><p class="colormain"><strong>NO </strong>tiene reflexión final<br /><strong>NO </strong>tendrás que enviarnos la respuesta al reto</p></div>
			<div class="col-md-4 text-center p-3"><p class="pl-2 pr-2"><img src="images/3point.png" class="img-fluid" style="max-width:160px"></p><p><strong>Ciclo de retos x3</strong><br /><span style="color:#00528D">(3 retos en un mes)</span></p><p>Este ciclo de retos está compuesto por 3 retos, vas a resolver un reto por semana. Cada reto cuenta con una cápsula de conocimiento y una actividad que debes resolver y enviarnos tu respuesta.</p><p class="colormain"><strong>SI</strong> tiene reflexión final<br />Varios ejercicios que te ayudan a <strong>sensibilizarte</strong> en la temática seleccionada</p></div>
			<div class="col-md-4 text-center p-3"><p class="pl-2 pr-2"><img src="images/6point.png" class="img-fluid" style="max-width:160px"></p><p><strong>Ciclo de retos x6</strong><br /><span style="color:#00528D">(6 retos en un mes)</span></p><p>Este ciclo de retos está compuesto por 6 retos, vas a resolver dos retos por semana. Cada reto cuenta con una cápsula de conocimiento y una actividad que debes resolver y enviarnos tu respuesta.</p><p class="colormain"><strong>SI</strong> tiene reflexión final<br />Varios ejercicios que te ayudan a <strong>profundizar</strong> en la temática seleccionada </p></div>
		</div>
		<div class="modal-footer">
		  	<button type="button" class="btn-w" data-dismiss="modal">Continuar</button>
		</div>
    </div>
  </div>
</div>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos</a>» <a class="bcrumb" href="#">Temática</a>
			</div>
			<p></p>
			<h1>{{$tematica->name}}</h1>
			<p class="pt-3">Estos son los ciclos de retos disponibles según la temática que seleccionaste. <strong>Haz clic en el título</strong> del que más te llame la atención para ver los detalles e inscribirte. </p>
            <p class="colormain" data-toggle="modal" data-target="#tipoCiclos" style="cursor: pointer"><small><i class="fa fa-eye"></i> Ver la explicación detallada</small></p>
		</div>
		<div class="col-md-6">&nbsp;</div>
	</div>
</div>
<div style="background-color: white" class="mb-5">
	<div class="container">
		<div class="row pr-4 pl-4 pt-3 pb-3">
		<div class="col-md-4 text-center p-3" @if($tipo == 1) style="border: 1px solid #ddd; border-radius:15px" @endif><p class="pl-2 pr-2">@if($tipo == 1) <p class="colormain text-center"><strong>Seleccionaste:</strong></p>@else<p><a href="ciclos-de-retos?tema={{$tematica->id}}&tipo=1">Haz clic aqui para ver:</a></p>@endif<img src="images/1point.png" class="img-fluid" style="max-width:160px"></p><p><strong>Reto único</strong><br /><span style="color:#00528D">(Sólo 1 reto abierto)</span></p></div>
		<div class="col-md-4 text-center p-3" @if($tipo == 3) style="border: 1px solid #ddd; border-radius:15px" @endif><p class="pl-2 pr-2">@if($tipo == 3) <p class="colormain text-center"><strong>Seleccionaste:</strong></p>@else<p><a href="ciclos-de-retos?tema={{$tematica->id}}&tipo=3">Haz clic aqui para ver:</a></p>@endif<img src="images/3point.png" class="img-fluid" style="max-width:160px"></p><p><strong>Ciclo de retos x3</strong><br /><span style="color:#00528D">(3 retos en un mes)</span></p></div>
		<div class="col-md-4 text-center p-3" @if($tipo == 6) style="border: 1px solid #ddd; border-radius:15px" @endif><p class="pl-2 pr-2">@if($tipo == 6) <p class="colormain text-center"><strong>Seleccionaste:</strong></p>@else<p><a href="ciclos-de-retos?tema={{$tematica->id}}&tipo=6">Haz clic aqui para ver:</a></p>@endif<img src="images/6point.png" class="img-fluid" style="max-width:160px"></p><p><strong>Ciclo de retos x6</strong><br /><span style="color:#00528D">(6 retos en un mes)</span></p></div>
	</div>
	</div>
</div>
<div class="container pb-5">
	@php
		if($tipo == 1) $seleccion = 'retos únicos';
		if($tipo == 3) $seleccion = 'ciclos de retos x3';
		if($tipo == 6) $seleccion = 'ciclos de retos x6';
	@endphp
	<div class="row">
		<div class="col-md-5">
            <p>Acá puedes seleccionar los <strong><u>{{$seleccion}}</u> </strong>disponibles para esta temática:</p>
            @if($tipo == 1)
                @foreach($ciclos as $ciclo)
                    <div class="card mb-3">
                        <div class="card-body p1r">
                            <p><strong><span class="mainblue">{{ $ciclo->name }}</span></strong><br />
                                <small><strong>Tema: {{$tematica->name}}</strong></small></p>
                            <a class="colormain" style="text-decoration: underline" href="reto-unico?ciclo={{$ciclo->id}}"><small>Haz click para ver el reto único de este ciclo de retos</small></a>
                        </div>
                    </div>
                @endforeach
            @else
                @if(count($ciclosTema)>0)
                    @foreach($ciclosTema as $cicloTema)
                        <div class="card mb-3">
                            <div class="card-body p1r">
                                <p><a class="mainblue" href="/detalle-ciclo?ciclo={{$cicloTema->id}}"><strong>{{ $cicloTema->name }}</strong></a><br />
                                <small><strong>Tema: {{$tematica->name}}</strong></small></p>
                                @if($ciclos->count() > 0)
                                <small>Fechas de inicio:</small> 
                                    @foreach($ciclos as $ciclo)
                                        @if($ciclo->course_id == $cicloTema->id)
                                            <small>{{fechaEs($ciclo->start_date)}}</small>&nbsp;
                                        @endif                            
                                    @endforeach
                                @else
                                <small class="colormain">¡Muy pronto nuevas fechas de programación!</small> 
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No hay {{$seleccion}} disponibles para esta temática</p>
                @endif
            @endif
		</div>
		<div class="col-md-2">
			&nbsp;
		</div>
		<div class="col-md-5">
			<p>Busca más ciclos de retos si no encuentras uno de tu interés</p>
			<form method="POST" action="{{route('cpe.resultado-busqueda-temas')}}" class="pt-1">
				@csrf                       
				<div class="form-group">
					<input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-gen" type="submit">BUSCAR</button>
				</div>
			</form>
			<p class="pt-3">&nbsp;</p>
			<img class="img-fluid" src="/images/buscar.png" alt="Imagen lupa buscar">
		</div>
	</div>

</div>
@endsection
@section('scripts')
    @if(!session('modal'))
		<script>
			$(document).ready(function(){
			$('#tipoCiclos').modal('show');
			}); 
		</script>>
    @php
        session(['modal' => true]);
    @endphp
	@endif
@endsection