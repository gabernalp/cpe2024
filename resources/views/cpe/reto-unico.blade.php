@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos</a>» <a class="bcrumb" href="#">Reto único</a>
			</div>
			<p></p>
			<h1>Reto único</h1>
			<p class="pt-1 colormain">{{$challenge->name}}</p>
		</div>
		<div class="col-md-6">&nbsp;</div>
	</div>
</div>
<div class="container pb-2">
	<div class="row">
		<div class="col-md-6">
            @if($challenge->capsule_file)
            <p><strong>Cápsula de conocimiento:</strong></p>
                @if(strpos($challenge->capsule_file->mime_type, 'audio') !== false)
                    <audio controls>
						  <source src="{{$challenge->capsule_file->getUrl()}}" type="{{$challenge->capsule_file->mime_type}}">
							Su navegador no soporta la reproducción de este tipo de archivo.
                    </audio>
                @else
                <p><a href="{{ $challenge->capsule_file->getUrl() }}" target="_blank"><strong>Ver/descargar cápsula</strong></a></p>
                @endif
            @endif
            <p>{!!nl2br($challenge->action_detail)!!}</p>
            <p class="colormain pb-4"><strong>* Al ser un reto único, no tienes que enviarnos una respuesta</strong></p>
            <a class="btn-w" href="detalle-ciclo?ciclo={{$challenge->course->id}}"><strong>Siguiente reto</strong></a>
		</div>
		<div class="col-md-6">
			<img class="img-fluid" src="/images/luz_home_2.png" />
		</div>
	</div>
    <div class="row pb-5">
        <div class="col-md-12">
        </div>
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