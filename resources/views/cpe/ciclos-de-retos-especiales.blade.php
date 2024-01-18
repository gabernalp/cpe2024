@extends('layouts.cpe')
@section('content')
<div id="infografia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="row m-0 pt-4 pr-4 pl-4">
			<div class="col-md-12">
                <img src="{{$tematica->imagen_especial->getUrl()}}" class="img-fluid">
			</div>
		</div>
		<div class="modal-footer">
		  	<button type="button" class="btn-w" data-dismiss="modal">Continuar</button>
		</div>
    </div>
  </div>
</div>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos</a>» <a class="bcrumb" href="#">Temática</a>
			</div>
			<p></p>
			<h1>{{$tematica->name}}</h1>
		</div>
		<div class="col-md-6">&nbsp;</div>
	</div>
</div>

<div class="container pb-5">
	@php
		$cuentaCiclos = 1;
	@endphp
	<div class="row">
		<div class="col-md-6">
            <p>Estos son los ciclos de retos disponibles según la temática que seleccionaste. <strong>Haz clic en el título</strong> del que más te llame la atención para ver los detalles e inscribirte. </p>
            <p class="colormain" style="cursor: pointer" data-toggle="modal" data-target="#infografia"><i class="fa fa-eye"></i> <strong>Ver la infografía acerca de esta estrategia</strong></p>
                @foreach($ciclosTema as $cicloTema)
                    <div class="card mb-3">
                        <div class="card-body p1r">
                            <h5 class="colormain">Ciclo No. {{$cuentaCiclos}}</h5>
                            <p><a class="mainblue" href="/detalle-ciclo?ciclo={{$cicloTema->id}}"><strong>{{ $cicloTema->name }}</strong></a><br />
                            <small><strong>Tema: {{$tematica->name}}</strong></small></p>
                            @if($ciclos->count() > 0)
                            <small>Fechas de inicio:</small> 
                                @foreach($ciclos as $ciclo)
                                    @if($ciclo->course_id == $cicloTema->id)
                                        <small>{{fechaEs($ciclo->start_date)}}</small>&nbsp;
                                    @endif                            
                                @endforeach
                            @else
                            <small class="colormain">¡Muy pronto nuevas fechas de programación!</small> 
                            @endif
                        </div>
                    </div>
                    @php
                    $cuentaCiclos++;
                    @endphp
                @endforeach
		</div>
		<div class="col-md-1">
			&nbsp;
		</div>
		<div class="col-md-5">
			<p>Busca más ciclos de retos si no encuentras uno de tu interés</p>
			<form method="POST" action="{{route('cpe.resultado-busqueda-temas')}}" class="pt-1">
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
    <script>
        $(document).ready(function(){
        $('#infografia').modal('show');
        }); 
    </script>>
@endsection