@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-5">
	<div class="row pb-4">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/recursos">Recursos y herramientas</a>» <a class="bcrumb" href="#">Subcategorias de recursos</a>
			</div>
		</div>
	</div>
	<div class="row pt-3">
		<div class="col-md-6 mb-3">
			<h1>{{$categoryView->name}}</h1>
				<p>Encuentra todo lo relacionado con referentes técnicos, contenidos de diplomados y cursos cortos, entre otros.</p>
				<p><strong>Selecciona la subcategoría de recursos que quieres ver:</strong></p>
		</div>
	</div>
	<div class="row">
		@php
			$i = 1;
		@endphp
		@foreach($resourcesSubcategories as $resourcesSubcategory)
		<div class="col-md-6"><a href="/ver-subcategoria?subcategoria={{$resourcesSubcategory->id}}&categoria={{$category}}">
			<div class="card mb-3" style="border-radius: 50px 10px 10px 50px">
			  <div class="card-body p-0">
				<img src="/images/numbers/{{$i}}.png" class="img-fluid" style="max-width:100px;"><span style="font-size:1rem; margin-left:15px">{{$resourcesSubcategory->name}}</span>
			  </div>
			</div></a>					
		</div>
		@php
			$i = $i+1;
		@endphp
		@endforeach
	</div>
</div>
<div class="jumbotron bgw">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3><strong>Otra categoría que también puede interesarte…</strong></h3>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-3 text-center p-3">
                <a class="p-3" href="/ver-categoria?categoria={{$categorySend->id}}"><img src="/images/bgprocesses/{{$categorySend->id}}.png" class="img-fluid">
            </div>
            <div class="col-md-3 p-3">
                <h4 class="colormain mt-3"><strong>{{$categorySend->name}}</strong></h4></a><p>{{$categorySend->description}}</p>
            </div>
            <div class="col-md-1">&nbsp;</div>
            <div class="col-md-4 pt-3">
                <p>O busca por palabra clave o frase  y encuentra más recursos de tu interés:</p>
                <form method="GET" action="{{ route('resultado-busqueda-recursos') }}" class="pt-2">
                @csrf                       
                <div class="form-group">
                    <input class="typeahead form-control" type="text" name="search_item" required>
                    <span class="help-block"></span>
                </div>
                <div class="text-right pt-3">
                    <button class="btn-w" type="submit">BUSCAR</button>
                </div>
                </form>
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
