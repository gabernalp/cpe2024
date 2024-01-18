@extends('layouts.cpe')
@section('content')
<div class="container pt-5">
	<div class="row ml-0">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos </a>» <a class="bcrumb" href="#">Ciclo de retos seleccionado </a>
			</div>
			<p></p>
			<h1>Ciclo de retos</h1>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row ml-0 pt-3">
		<div class="col-md-6">
			<p class="colormain"><strong>{{$ciclo->name}}</strong></p>
		</div>
	</div>
	<div class="row ml-0 pt-1">
		<div class="col-md-6">
			<p><small><strong>Tema: {{$ciclo->tematica_asociada->name}}</strong><br />
				@php
				@endphp
				Inicio en: </small>
				@foreach($programaciones as $programacion)
					<small> {{fechaEs($programacion->start_date)}}</small>&nbsp;
				@endforeach
				<br />
				<small>Duración: 4 semanas</small>
			</p>
			<hr>
			<p class="pb-4">{{$ciclo->goal}}</p>
			<div class="row">
				@foreach($programaciones as $programacion)
				<div class="col-md-6">
					<a href="/inscripcion-ciclo?prog={{$programacion->id}}">
						<div class="card mb-3">
							<div class="card-body text-center" style="padding: 0.5rem">
								<p class="colormain pt-1">
								<strong>¡Inscribirme!<br />
									{{fechaEs($programacion->start_date)}}</strong>
								</p>
							</div>
						</div>
					</a>
				</div>
				@endforeach
			</div>
		</div>
		<div class="col-md-1">&nbsp;</div>
		<div class="col-md-4">
			<img class="img-fluid" src="/images/detalletemas.jpg" alt="Imagen de Luz">
		</div>
		<div class="col-md-1">&nbsp;</div>
	</div>
</div>
<div class="jumbotron bgw mb-0">
	<div class="container">
        <div class="row pb-3">
            <div class="col-md-6">
                <h3><strong>Otros ciclos que también pueden interesarte...</strong></h3>
            </div>
        </div>
		<div class="row pt-3">
			<div class="col-md-6">
                @if($aleatorios->count() > 0)
                    @foreach($aleatorios as $cicloTema)
                    <div class="card mb-3">
                        <div class="card-body p1r">
                            <p><a class="mainblue" href="/detalle-ciclo?ciclo={{$cicloTema->id}}"><strong>{{ $cicloTema->name }}</strong></a><br />
                            <small><strong>Tema: {{$cicloTema->tematica_asociada->name}}</strong></small></p>
                            <small>Fecha de inicio:</small>
                            <small>{{fechaEs($cicloTema->start_date)}}</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <h3 class="colormain">¡Muy pronto tendremos más ciclos de retos para ti!</h3>
                @endif
			</div>
			<div class="col-md-1">&nbsp;</div>
            <div class="col-md-5">
                <p>O busca más ciclos de retos si no encuentras uno de tu interés</p>
                <form method="POST" action="{{route('cpe.resultado-busqueda-temas')}}" class="pt-1">
                    @csrf                       
                    <div class="form-group">
                        <input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
                        <span class="help-block"></span>
                    </div>
                    <div class="text-right"><button class="btn-gen" type="submit">BUSCAR</button>
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
@parent
@endsection