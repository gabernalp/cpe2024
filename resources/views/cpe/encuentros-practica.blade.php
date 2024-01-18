@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y encuentros</a> » <a class="bcrumb" href="#">Encuentros de práctica</a>
			</div>
			<p></p>
			<h1>Encuentros de práctica</h1>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row pb-5">
		<div class="col-md-6">
			<p class="pt-3 pb-4">Un encuentro de Práctica es un espacio de interacción de un grupo de personas con intereses afines que reflexionan sobre su práctica profesional, se apoyan y además construyen conjuntamente aprendizajes que les ayudan a desarrollarse y mejorar en su labor.</p>
			<p class="pb-4"><strong>Aquí podrás crear o asistir a encuentros, espacios donde vas a conocer personas de otras regiones para compartir y escuchar aprendizajes en grupos de hasta 10 integrantes.</strong></p>
			<div class="row ml-0 mr-0">
				<div class="col-md-6 pl-0 pb-3">
					@if(Auth::check())
						<a href="/crear-encuentro" class="btn-w w100 btn-block p-1 text-center">Crear un encuentro</a>
					@else
						<a href="/login" class="btn-w w100 btn-block p-1 text-center">Crear un encuentro</a>
					@endif
				</div>
				<div class="col-md-6 pl-0 pb-3">
						<a href="#proximos" class="btn-w w100 btn-block p-1 text-center">Ver próximos encuentros</a>
				</div>				
			</div>
		</div>
		<div class="col-md-1">
			&nbsp;
		</div>
		<div class="col-md-5 pt-4">
			<div class="video-responsive">
				<iframe src="https://www.youtube.com/embed/3a0gEv2dbEA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
<div class="row" id="proximos"><img src="/images/separador.jpg" class="img-fluid"></div>
<div class="jumbotron bgw mb-0 pt-5">
	<div class="container pt-3">
		<div class="row pt-3 pb-5">
			<div class="col-md-5">
				<h1 class="colormain">Próximos encuentros</h1>
			</div>
			<div class="col-md-1">&nbsp;</div>
			<div class="col-md-6">
				<form method="POST" action="{{route('cpe.resultado-busqueda-encuentros')}}" class="pt-1">
                    
				@csrf                       
				<div class="form-group">
					<input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-w" type="submit">BUSCAR</button>
				</div>
			</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-5 pt-5 pb-3">
                <img src="/images/comunidad-transparente.png" class="img-fluid">
            </div>
			<div class="col-md-7">
                @if(count($meetings)>0)
                    @foreach($meetings as $meeting)
                    <div class="card mb-3">
                        <div class="card-body p1r">
                            <div class="row">
                                <div class="col-md-9">
                                    <p><strong><span class="colormain">{{ $meeting->title }}</span></strong><br />
                                    <small><strong>Encuentro creado por: </strong>{{$meeting->user->name}}, {{$meeting->user->department->name ?? ''}}</small><br />
                                    <small><strong>Propósito: </strong>{{$meeting->description}}</small><br />
                                    <small><strong>Metodología: </strong>{{$meeting->methodology}}</small><br />
                                    <small><strong>Fecha: </strong>{{fechaEs($meeting->date)}}</small><br />
                                    <small><strong>Hora: </strong>{{$meeting->time}} | <strong>Duración: </strong>{{$meeting->meeting_term}} minutos</small><br />
                                </div>
                                <div class="col-md-3 pt-3 text-right">
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
                <h5>No hay encuentros futuros programados</h5>
                @endif
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
@parent
@endsection