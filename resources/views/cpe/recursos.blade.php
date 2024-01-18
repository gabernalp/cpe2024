@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="#">Recursos y herramientas</a>
			</div>
			<p></p>
			<h1>Recursos y herramientas</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<p class="pt-3">Aquí encuentras recursos y herramientas que el ICBF y el Ministerio de Educación prepararon para enriquecer tu labor y tu formación. Puedes consultar, descargar y compartir esta información.</p>
			<p><strong>Para empezar selecciona la categoría de recursos que quieres explorar:</strong></p>
		</div>
	<div class="col-md-1">&nbsp;</div>
	<div class="col-md-5">
			<h4><strong>Búsqueda avanzada</strong></h4>
			<form method="GET" action="{{ route('resultado-busqueda-recursos') }}" class="pt-2">
				@csrf                       
				<div class="form-group">
                    <input class="typeahead form-control" type="text" name="search_item" placeholder="Búsqueda por palabra clave o frase" required>
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-w" type="submit">BUSCAR</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="jumbotron mb-0 pb-0">
	<div class="container pb-0">
		<div class="row">
			@foreach($resourcesCategories as $resourcesCategory)
				<div class="col-md-4 text-center pb-5 pl-3 pr-3"><a href="/ver-categoria?categoria={{$resourcesCategory->id}}"><img src="/images/bgprocesses/{{$resourcesCategory->id}}.png" class="img-fluid"><h4 class="colormain"><strong>{{$resourcesCategory->name}}</strong></h4></a><p>{{$resourcesCategory->description}}</p></div>
			@endforeach
		</div>
	</div>
</div>
<div class="jumbotron bgw mt-0 mb-0 p-0 bgpink">
    <div class="container">
        <div id="carouselBanners" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            @php
              $i=1;
            @endphp
            @foreach($banners as $banner)
            <div class="carousel-item @if($i == 1){{'active'}}@endif">
              <a href="{{$banner->link}}" target="_blank"><img class="d-block w-100" src="{{$banner->image->getUrl()}}" alt="{{$banner->name}}"></a>
            </div>
            @php
              $i = $i+1;
            @endphp
            @endforeach
          </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script type="text/javascript">
        var path = "{{ route('cpe.autocomplete') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });
    </script>
@endsection