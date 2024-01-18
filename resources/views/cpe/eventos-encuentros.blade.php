@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y encuentros</a></a>
			</div>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-5 pt-5">
            <h1>Quiero participar en eventos y encuentros</h1>
			<p class="pt-3">En esta sección vas a encontrar todos los próximos eventos institucionales que hay disponibles, memorias y grabaciones de eventos pasados y además podrás acceder a los <strong>encuentros de práctica</strong> para conocer, compartir y aprender de personas en todo Colombia.</p>
            <p class="p-3">&nbsp;</p>
            <h4 class="mt-5"><strong>¿Qué quieres explorar hoy?</strong></h4>
		</div>
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-5 p-5">
			<img class="img-fluid" src="/images/comunidad-transparente.png" alt="Imagen Aprender en comunidad">
		</div>
	</div>
    <div class="row">
        <div class="col-md-4 pb-2">
            <a class="BUTTON_MKL3 w100" href="/eventos-institucionales"><h5>Eventos institucionales</h5></a>
        </div>
        <div class="col-md-4 pb-2">
        @if(env('ENCUENTROS') == 'encendido')
            <a class="BUTTON_MKL3 w100" href="/encuentros-practica"><h5>Encuentros de práctica</h5></a>
        @else
            <a class="BUTTON_MKL3 w100" href="javascript:alert('Muy pronto podrás crear tus encuentros de práctica para conocer, compartir y aprender de personas en todo Colombia')"><h5>Encuentros de práctica</h5></a>
        @endif
        </div>        
        <div class="col-md-4 pb-2">
            <a class="BUTTON_MKL3 w100" href="/memorias-grabaciones"><h5>Memorias y grabaciones</h5></a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
@endsection	