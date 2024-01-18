@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12 pb-5">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos</a></a>
			</div>
			<p></p>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-6 pr-5">
			<h1>Quiero participar en ciclos de retos</h1>
			<p class="pt-3">Cada mes comenzamos distintos ciclos de retos, donde puedes fortalecer tu labor a través de ejercicios prácticos, cortos y flexibles. </p><p class="pt-3">Puedes escoger la temática en la que quieres fortalecerte, en cada una vas a encontrar diferentes ciclos de retos, cada ciclo de retos está compuesto por 3 o por 6 retos y dura 4 semanas.Puedes realizar los retos en tus tiempos y aplicar lo aprendido en tu día a día.</p><p class="pt-3"><strong>¿Qué esperas para inscribirte?</strong></p>
			<a class="colormain" style="text-decoration:underline" href="#video"><strong><i class="fa fa-eye"></i> Mira el video acerca de cómo funciona esta sección</strong></a><br />
		</div>
		<div class="col-md-6 text-center">
            <img class="img-fluid" src="/images/fortalecer-transparente.png" alt="Imagen fortalecer mi labor">
            <p class="pt-3"><a class="colormain pt-3" style="text-decoration:underline" href="/mi-perfil"><strong><i class="fas fa-hand-point-right"></i> Si ya estas inscrito, ve a 'Mi Perfil' para acceder a los retos</strong></a></p>
                            
		</div>
	</div>
			<p style="font-size:1.5rem" class="pt-5"><strong>Seleciona una temática:</strong></p>

		<div class="row pt-1">
		@foreach($background_processes as $id => $background_processes)
			<div class="col-md-4 mb-4">
				<a href="ciclos-de-retos?tema={{$id}}&tipo=1"><button class="BUTTON_MKL3">{{$background_processes}}</button></a>
			</div>
		@endforeach
		</div>

</div>
<div class="row" id="video"><img src="/images/separador.jpg" class="img-fluid"></div>
<div class="jumbotron bgw mb-0">
	<div class="container pt-3">
		<div class="row pt-3 justify-content-center">
			<div class="col-md-6">
				<h3 class="colormain pb-4 text-center"><strong>¡Conoce como funciona!</strong></h3>
				<iframe style="width:100%; height:auto; min-height: 315px" src="https://www.youtube.com/embed/mqFVZVqUnjg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
@parent
@endsection