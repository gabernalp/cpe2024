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
		@if(count($courses)>0)
			<p class="pb-3"><strong>Haz clic en el título</strong> para obtener más información.</p>
			@foreach($courses as $course)
				<div class="card mb-3">
					<div class="card-body p1r">
						<p><strong><a class="colormain" href="/detalle-ciclo?ciclo={{$course->id}}">{{ $course->name }}</a></strong><br />
						<small><strong>Tema: {{$course->tematica_asociada->name}}</strong></small></p>
					</div>
				</div>
			@endforeach
		@else
			<p class="colormain"><strong>Tu búsqueda no produjo resultados, intenta nuevamente</strong></p>
		@endif
		</div>
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-5">			
			<p>Busca más ciclos de retos si no encuentras uno de tu interés</p>
			<form method="POST" action="{{ route('cpe.resultado-busqueda-temas') }}" class="pt-1">
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