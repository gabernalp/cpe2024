@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y encuentros</a> » <a class="bcrumb" href="#">Eventos institucionales</a>
			</div>
			<p></p>
			<h1>Memorias</h1>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-6">
			<p class="pt-3 pb-4">Acá puedes explorar las memorias de los eventos pasados de la Comunidad de Aprendizaje del ICBF. Son audios cortos en donde se resumen los principales aprendizajes del evento.</p>
			<img class="img-fluid" src="/images/luz_home_1.png" />
		</div>
		<div class="col-md-1">
			&nbsp;
		</div>
		<div class="col-md-5">
			<form method="POST" action="{{route('resultado-busqueda-memorias')}}" class="pt-1">
				@csrf                       
				<div class="form-group">
					<input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-w" type="submit">BUSCAR</button>
				</div>
			</form>
			@if(count($events) > 0)
			@foreach($events as $event)
			<div class="row pt-5">
			<div class="card mb-3 w100">
					<div class="card-body p1r">
						<p><small></strong>{{$event->title}}</strong></small><br />
						@if($event->date)
							<small>Fecha: {{fechaEs($event->date)}}</small>
						@endif
						</p>
						@if($event->podcast)
						<audio controls>
						  <source src="{{$event->podcast->getUrl()}}" type="{{$event->podcast->mime_type}}">
							Su navegador no soporta la reproducción de este tipo de archivo.
						</audio>
						@endif
					</div>
				</div>
			</div>
			@endforeach
			@else
			<div class="row">
				<p class="pt-3 colormain">No hay eventos futuros programados aún. Recuerda volver a esta sección periódicamente para enterarte de las nuevas programaciones y detalles.</p>
			</div>
			@endif
			</div>
		</div>
	</div>
</div>
<div class="row" id="video"><img src="/images/separador.jpg" class="img-fluid"></div>
<div class="jumbotron bgw mb-0">
	<div class="container pt-3">
		<div class="row pt-3 pb-5">
			<div class="col-md-6">
				<h1 class="colormain">¿Te lo perdiste?</h1>
				<h4 class="colormain">Revisa la grabación del evento completo</h4>
			</div>
		</div>
		<div class="row">
			@if(count($events) > 0)
				@foreach($events as $event)
				<div class="col-md-4 mb-3">
					<div class="video-responsive">{!!$event->video_embed!!}</div>
					<p class="pt-2"><small><strong>{{$event->title}}</strong><br />Fecha: {{$event->date}}</small></p>
				</div>
				@endforeach
			@else
				<div class="col-md-6">
					<p>No hay eventos para mostrar.</p>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent
@endsection