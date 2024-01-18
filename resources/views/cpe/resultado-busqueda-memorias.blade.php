@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row pb-4">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/memorias-grabaciones">Memorias </a>» <a class="bcrumb" href="#">Resultados de la búsqueda</a>
			</div>
			<h1 class="pb-3 pt-3">Resultado de tu búsqueda</h1>
			<h5 class="pb-1">Palabra clave: "<em>{{$sterm}}</em>"</h5>
		</div>
	</div>
	<div class="row pb-5">
		<div class="col-md-5">
		@if(count($memories)>0)
			@foreach($memories as $memory)
				<div class="card mb-3">
					<div class="card-body p1r">
						<p><strong class="colormain">{{ $memory->title }}</strong><br />
						<small><strong>Fecha: {{$memory->date}}</strong></small></p>
						@if($memory->podcast)
						<audio controls>
						  <source src="{{$memory->podcast->getUrl()}}" type="audio/mpeg">
							Su navegador no soporta la reproducción de este tipo de archivo.
						</audio>
						@endif
					</div>
				</div>
			@endforeach
		@else
			<p class="colormain"><strong>Tu búsqueda no produjo resultados, intenta nuevamente</strong></p>
		@endif
		</div>
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-5">			
			<p>Busca más memorias si no encuentras una de tu interés</p>
			<form method="POST" action="{{ route('resultado-busqueda-memorias') }}" class="pt-1">
				@csrf                       
				<div class="form-group">
					<input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-w" type="submit">BUSCAR</button>
				</div>
			</form>
			<p class="pt-3">&nbsp;</p>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent
@endsection