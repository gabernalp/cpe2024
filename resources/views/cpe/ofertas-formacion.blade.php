@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-5">
	<div class="row">
		<div class="col-lg-6 col-md-12 col-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="#">Quiero participar en ofertas de formación</a>
			</div>
			<p></p>
			<h1>Quiero participar en ofertas de formación</h1>
		</div>
	</div>
    @if(env("OFERTAS") == 'encendido')
    <form action="{{route('cpe.busquedaOfertas')}}" method="post">
    @csrf
    
    <div class="row">
            <div class="col-lg-6 col-md-12 col-12 pr-5">
                <h5><strong>¡Bienvenidos!</strong></h5>
                <p>Agradecemos tu interés por participar en los procesos de formación y cualificación. Recuerda que estos procesos fortalecen las capacidades humanas a partir del reconocimiento de saberes, experiencias y competencias laborales para el mejoramiento de la calidad de los servicios de Educación Inicial del ICBF.</p>
                <p>Este año tendremos una oferta amplia de programas de formación y cualificación <strong>gratuitos</strong>.</p>


                    <p><strong>¡Participa y aprovecha esta gran oportunidad!</strong><br />Para acceder a nuestra oferta <strong>PREINSCRÍBETE</strong> en el siguiente formulario diligenciando y seleccionando tus datos. Proporciona información actualizada para contactarnos contigo:</p>
                    <div class="form-group">
                        <label class="required" for="department_id">{{ trans('cruds.user.fields.department') }}</label>
                        <select required class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id">
                            @foreach($departments as $id => $entry)
                                <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('department'))
                            <div class="invalid-feedback">
                                {{ $errors->first('department') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.department_helper') }}</span>
                    </div>
                    <div class="form-group">
                    <label class="required" for="entidad_asociada_id">Entidad a la que perteneces</label>
                        <select class="form-control {{ $errors->has('entidad_asociada') ? 'is-invalid' : '' }}" name="entidad_asociada_id" id="entidad_asociada_id">
                            @foreach($entidad_asociadas as $id => $entry)
                                <option value="{{ $id }}" {{ old('entidad_asociada_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('entidad_asociada'))
                            <div class="invalid-feedback">
                                {{ $errors->first('entidad_asociada') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.profile.fields.entidad_asociada_helper') }}</span>
                    </div>
                    <div class="form-group" id ="profileIcbf" style="display: none">
                        <label class="required" for="profile_id">Tu cargo es:</label>
                        <select class="form-control {{ $errors->has('profile') ? 'is-invalid' : '' }}" name="profile_id" id="profile_id">
                            @foreach($profiles as $id => $entry)
                                <option value="{{ $id }}" {{ old('profile_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('profile'))
                            <div class="invalid-feedback">
                                {{ $errors->first('profile') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.profile_helper') }}</span>
                    </div>
                <div class="row pt-3">
                    <div class="col-md-12 text-right"><button type="submit" class="btn-gen">BUSCAR</button></div>
                </div>
            </div>
            <div class="col-lg-1 col-md-12 col-12">&nbsp;</div>
            <div class="col-lg-5 col-md-12 col-12">
                <img class="img-fluid" src="/images/diploma.jpg" alt="Imagen fortalecer mi labor">
            </div>
        </div>
    </form>
    @else
    <h3>No hay ofertas disponibles en este momento.</h3>
    @endif
</div>
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="colormain text-center pb-3">Linea de tiempo proceso de ofertas de formación</h1>
            <img src="/images/linea-tiempo.jpg" class="img-fluid">
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
<!--Validacion si es cargo ICBF-->
<script>
    $('#entidad_asociada_id').on('change',function(){
        if(($(this).val()==1)) {

            document.getElementById('profileIcbf').style.display = "block";
            document.getElementById('profile_id').required = true;
        }
        else{

            document.getElementById('profileIcbf').style.display = "none";
            document.getElementById('profile_id').required = false;        
        }
    });
</script>
@endsection