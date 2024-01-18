@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-5">
	<div class="row">
		<div class="col-md-6 pb-3">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="#">Quiero participar en ofertas de formación</a>
			</div>
			<h1 class="pt-5">Quiero participar en ofertas de formación</h1>
		</div>
	</div>
    <form method="post" action="{{route('cpe.inscribirOfertas')}}">

        @csrf
    
        <div class="row">
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <div class="col-md-6">
                <div class="alert alert-secondary" role="alert">
                    <h5 class="colorsite"><i class="fa fa-info-circle fa-colorsite fa-xl"></i> ¿Cómo registrarse en el proceso?</h5>
                    <p>Recuerda que la oferta de formación y cualificación <strong>están dirigidas al talento humano que labora en los servicios de educación inicial del ICBF</strong>. Si cumples con este requisito déjanos tus datos, serás contactado si fuiste seleccionado para hacer parte de un proceso de formación.</p>
                </div>
                <h3 class="colormain pt-3 pb-2">Resultado de la búsqueda de ofertas:</h3>
                <p class="required">Hemos encontrado estas ofertas de formación y cualificación según tu cargo. Puedes seleccionar <u><strong>máximo 3 opciones</strong></u> y posteriormente diligenciar tus datos personales.</p><hr />
                @foreach($profile->coursehooks as $key => $coursehook)
                    <p><span class="colorsite"><strong>{{ $coursehook->name }}</strong></span></p>
                    <p></p>
                    <input name="courseshooks[]" value="{{ $coursehook->id }}" type="checkbox"> ¡Me interesa!
                    <hr>
                @endforeach           
            </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <h4>Formulario</h4>
                        <div class="form-group">
                            <label class="required" for="name">Nombres</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="lastname">Apellidos</label>
                            <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', '') }}" required>
                            @if($errors->has('lastname'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('lastname') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.lastname_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="email">{{ trans('cruds.selfInterestedUser.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="documenttype_id">{{ trans('cruds.selfInterestedUser.fields.documenttype') }}</label>
                            <select class="form-control {{ $errors->has('documenttype') ? 'is-invalid' : '' }}" name="documenttype_id" id="documenttype_id" required>
                                @foreach($documenttypes as $id => $documenttype)
                                    <option value="{{ $id }}" {{ old('documenttype_id') == $id ? 'selected' : '' }}>{{ $documenttype }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('documenttype'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('documenttype') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.documenttype_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="document">{{ trans('cruds.selfInterestedUser.fields.document') }}</label>
                            <input class="form-control {{ $errors->has('document') ? 'is-invalid' : '' }}" type="number" name="document" id="document" value="{{ old('document', '') }}" step="1" required>
                            @if($errors->has('document'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('document') }}
                                </div>
                            @endif
                            <span class="help-block"><em><small>Digitalo sin puntos ni comas ni espacios</small></em></span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="document_date">{{ trans('cruds.selfInterestedUser.fields.document_date') }}</label>
                            <input class="form-control date {{ $errors->has('document_date') ? 'is-invalid' : '' }}" type="text" name="document_date" id="document_date" value="{{ old('document_date') }}" required>
                            @if($errors->has('document_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('document_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.document_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="required">{{ trans('cruds.selfInterestedUser.fields.phone') }}</label>
                            <input required class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.phone_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">“¿Has recibido formación por parte del ICBF en los últimos 5 años?</label>
                            @foreach(App\Models\SelfInterestedUser::EDUCATION_BACKGROUND_RADIO as $key => $label)
                                <div class="form-check {{ $errors->has('education_background') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="education_background_{{ $key }}" name="education_background" value="{{ $key }}" {{ old('education_background', '') === (string) $key ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="education_background_{{ $key }}">{{ $label }}</label>
                                </div>
                            @endforeach
                            @if($errors->has('education_background'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('education_background') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.education_background_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">Modalidad de tu labor</label>
                            <select class="form-control {{ $errors->has('modality') ? 'is-invalid' : '' }}" name="modality" id="modality" required>
                                <option value disabled {{ old('modality', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\SelfInterestedUser::MODALITY_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('modality', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('modality'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('modality') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.modality_helper') }}</span>
                        </div>                        
                        <div class="form-group">
                            <label for="department_id">Departamento donde laboras</label>
                            <select class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department">
                                @foreach($departments as $id => $department)
                                    <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $department }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('department'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('department') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.department_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="city_id">Municipio donde laboras</label>
                            <select class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city">
                            </select>
                            @if($errors->has('city'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.selfInterestedUser.fields.living_zone') }}</label>
                            <select class="form-control {{ $errors->has('living_zone') ? 'is-invalid' : '' }}" name="living_zone" id="living_zone" required>
                                <option value disabled {{ old('living_zone', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\SelfInterestedUser::LIVING_ZONE_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('living_zone', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('living_zone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('living_zone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.living_zone_helper') }}</span>
                        <div class="form-group pt-4">
                            <button class="btn btn-gen" type="submit" onClick="return confirm('Acepto que todos los datos que he digitado los he verficado y se ajustan a la verdad')">
                                PREINSCRIBIRME
                            </button>
                        </div>
                </div>
            </div>
      </div>
    </form>
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