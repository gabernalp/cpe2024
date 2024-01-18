@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos</a>» <a class="bcrumb" href="#">Temática</a>
			</div>
			<p></p>
			<h1>Busqueda</h1>
            <input class="typeahead form-control" type="text">
		</div>
		<div class="col-md-6">&nbsp;</div>
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