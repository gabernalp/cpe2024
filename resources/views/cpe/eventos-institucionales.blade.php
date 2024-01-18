@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y encuentros</a> » <a class="bcrumb" href="#">Eventos institucionales</a>
			</div>
			<p></p>
			<h1>Eventos institucionales</h1>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-6">
			<p class="pt-3">Acá vas a encontrar la lista de los próximos eventos institucionales del ICBF y del Ministerio de Educación.</p>
		</div>
	</div>
	<div  class="row">
		@if(count($events) > 0)
			@foreach($events as $event)
			<div class="col-md-6">
				<div class="card mb-3">
					<div class="card-body p1r">
						<p><strong class="colormain">Comunidad de Aprendizaje</strong><br />
						<small><strong>Tema: {{$event->title}}</strong></small></p>
						<p><small>{!!$event->description!!}</small></p>
						@if($event->date)
							@php
								$fecha = Carbon\Carbon::parse($event->date);
							@endphp
							<p><small>Fecha: {{$fecha->toFormattedDateString()}}</small></p>
						@endif
						@if($event->link)
							<p><a target="_blank" href="{{$event->link}}" class="colormain"><small><strong>Acceder al evento</strong></small></a><br />
							<small class="colormain">*Accede al evento con este link el día y a la hora del evento</small></p>
						@endif
					</div>
				</div>
			</div>
			@endforeach
		@else
		<div class="col-md-6">
			<p class="pt-3 colormain">No hay eventos futuros programados aún. Recuerda volver a esta sección periódicamente para enterarte de las nuevas programaciones y detalles.</p>
		</div>
		@endif
	</div>
</div>
@endsection
@section('scripts')
@parent
@endsection