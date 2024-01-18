@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-5">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="#">Quiero participar en ofertas de formación</a>
			</div>
			<p></p>
			<h1>Quiero participar en ofertas de formación</h1>
		</div>
	</div>
    <h3 class="colormain pt-3 pb-2">Resultado de la búsqueda de ofertas:</h3>
    <div class="row">
        @foreach($results as $result)
          <div class="col-sm-6 pb-2">
            <div class="card" style="height:100%">
              <div class="card-body">
                <p><span class="colorsite"><strong>{{ $result->name }}</strong></span></p>
                <p><a href="{{ $result->link }}" target="_blank"><span>Clic aqui para ir al link del portal Contacto Maestro</span></a></p>
                </div>
            </div>
        </div>
        @endforeach
  </div>
</div>
@endsection
@section('scripts')
<script>
    jQuery(function(){
        var max = 3;
        var checkboxes = jQuery('input[type="checkbox"]');

        checkboxes.click(function(){
            var $this = $(this);
            var set = $this.add($this.prevUntil('label')).add($this.nextUntil('label'));
            var current = set.filter(':checked').length;
            return current <= max;
        });
    });
</script>
<script type="text/javascript">
    $("#department").change(function(){
        $.ajax({
            url: "{{ route('admin.cities.get_by_department') }}?department_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#city').html(data.html);
            }
        });
    });
</script>
@endsection