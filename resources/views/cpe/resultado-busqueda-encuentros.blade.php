@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row pb-4">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/participar-ciclos-de-retos">Participar en ciclos de retos </a>» <a class="bcrumb" href="#">Resultados de la búsqueda</a>
			</div>
			<h1 class="pb-3 pt-3">Resultado de tu búsqueda</h1>
			<h5 class="pb-3">Palabra clave: "<em>{{$sterm}}</em>"</h5>
		</div>
	</div>
	<div class="row pb-5">
		<div class="col-md-5">
		@if(count($meetings)>0)
				@foreach($meetings as $meeting)
				<div class="card mb-3">
					<div class="card-body p1r">
						<div class="row">
							<div class="col-md-8">
								<p><strong><span class="colormain">{{ $meeting->title }}</span></strong><br />
								<small><strong>Encuentro creado por: </strong>{{$meeting->user->name}}, {{$meeting->user->department->name ?? ''}}</small><br />
								<small><strong>Propósito: </strong>{{$meeting->description}}</small><br />
								<small><strong>Metodología: </strong>{{$meeting->methodology}}</small><br />
								<small><strong>Fecha: </strong>{{fechaEs($meeting->date)}}</small><br />
								<small><strong>Hora: </strong>{{$meeting->time}} | <strong>Duración: </strong>{{$meeting->meeting_term}} minutos</small><br />
							</div>
							<div class="col-md-4 pt-5 text-center">
								@if(Auth::check())
									<a href="/unirme-encuentro?encuentro={{$meeting->id}}" class="btn-gen">Unirme</a>
								@else
									<a href="/login" class="btn-gen">Unirme</a>
								@endif
							</div>
						</div>

					</div>
				</div>
				@endforeach
		@else
			<p class="colormain"><strong>Tu búsqueda no produjo resultados, intenta nuevamente</strong></p>
		@endif
		</div>
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-5">			
			<p>Busca más encuentros si no encuentras uno de tu interés</p>
			<form method="POST" action="{{ route('cpe.resultado-busqueda-encuentros') }}" class="pt-1">
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
@parent
@endsection