@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y enciuentros</a> » <a class="bcrumb" href="/encuentros-practica">Encuentros de práctica</a> » <a class="bcrumb" href="#">Crear encuentro</a>
			</div>
			<h1>Crear un encuentro</h1>
			<p></p>
			<p class="pt-3 pb-4">Completa los siguientes datos para programar el encuentro y en cuanto confirmen mínimo 3 personas les enviaré la invitación con el link al correo a todos.</p>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<form method="POST" action="{{ route("cpe.crear-encuentro.store") }}" enctype="multipart/form-data">
		@csrf
	<input type="hidden" name="user_id" value="{{auth()->id()}}">
	<div class="row pb-5">
		<div class="col-md-6">
            <div class="form-group">
                <label class="required" for="title">Tema del encuentro</label>
                <input placeholder="Resume en una oración el tema del encuentro" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">Describe el proposito de tu encuentro</label>
                <textarea placeholder="Propósito del encuentro de acuerdo al tema que elegiste." rows="2" style="min-height: 0px" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.description_helper') }}</span>
            </div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="required" for="date">{{ trans('cruds.meeting.fields.date') }}</label>
						<input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}" required>
						@if($errors->has('date'))
							<div class="invalid-feedback">
								{{ $errors->first('date') }}
							</div>
						@endif
						<span class="help-block">{{ trans('cruds.meeting.fields.date_helper') }}</span>
					</div>		
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="required" for="time">Hora</label>
						<input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time') }}" required>
						@if($errors->has('time'))
							<div class="invalid-feedback">
								{{ $errors->first('time') }}
							</div>
						@endif
						<span class="help-block">{{ trans('cruds.meeting.fields.time_helper') }}</span>
					</div>			
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="required">{{ trans('cruds.meeting.fields.meeting_term') }}</label>
						<select required class="form-control {{ $errors->has('meeting_term') ? 'is-invalid' : '' }}" name="meeting_term" id="meeting_term">
							<option value disabled {{ old('meeting_term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
							@foreach(App\Models\Meeting::MEETING_TERM_SELECT as $key => $label)
								<option value="{{ $key }}" {{ old('meeting_term', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
							@endforeach
						</select>
						@if($errors->has('meeting_term'))
							<div class="invalid-feedback">
								{{ $errors->first('meeting_term') }}
							</div>
						@endif
						<span class="help-block">{{ trans('cruds.meeting.fields.meeting_term_helper') }}</span>
					</div>				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="required">{{ trans('cruds.meeting.fields.methodology') }}</label>
						<select required class="form-control {{ $errors->has('methodology') ? 'is-invalid' : '' }}" name="methodology" id="methodology">
							<option value disabled {{ old('methodology', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
							@foreach(App\Models\Meeting::METHODOLOGY_SELECT as $key => $label)
								<option value="{{ $key }}" {{ old('methodology', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
							@endforeach
						</select>
						@if($errors->has('methodology'))
							<div class="invalid-feedback">
								{{ $errors->first('methodology') }}
							</div>
						@endif
						<span class="help-block">{{ trans('cruds.meeting.fields.methodology_helper') }}</span>
					</div>				
				</div>			
			</div>
		</div>
		<div class="col-md-1">
			&nbsp;
		</div>
		<div class="col-md-5">
          <div class="form-group">
                <label for="technical_referrers">¿Sobre qué <u>referente técnico</u> de educación inicial quieres basar tu encuentro? <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" data-html="true" title="<small>Serie de documentos y guías que ofrecen criterios conceptuales, metodológicos y operativos para mejorar la calidad de la atención integral en las modalidades de educación inicial, además de acompañar y dotar de sentido las prácticas inscritas en la educación de las niñas y los niños menores de seis años.</small>"></i></label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('technical_referrers') ? 'is-invalid' : '' }}" name="technical_referrers[]" id="technical_referrers" multiple>
                    @foreach($technical_referrers as $id => $technical_referrers)
                        <option value="{{ $id }}" {{ in_array($id, old('technical_referrers', [])) ? 'selected' : '' }}>{{ $technical_referrers }}</option>
                    @endforeach
                </select>
                @if($errors->has('technical_referrers'))
                    <div class="invalid-feedback">
                        {{ $errors->first('technical_referrers') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.technical_referrers_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="otro_referente">Si tienes otro referente técnico escribe aquí:</label>
                <input class="form-control {{ $errors->has('otro_referente') ? 'is-invalid' : '' }}" type="text" name="otro_referente" id="otro_referente" value="{{ old('otro_referente', '') }}">
                @if($errors->has('otro_referente'))
                    <div class="invalid-feedback">
                        {{ $errors->first('otro_referente') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.otro_referente_helper') }}</span>
            </div>
			<div class="form-group">
                <div class="form-check {{ $errors->has('teachers_network') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="teachers_network" value="0">
                    <input class="form-check-input" type="checkbox" name="teachers_network" id="teachers_network" value="1" {{ old('teachers_network', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="teachers_network">Selecciona esta casilla si estas vinculado alguna red de maestros</label>
                </div>
                @if($errors->has('teachers_network'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teachers_network') }}
                    </div>
                @endif
            </div>
            <div class="form-group text-right pt-3">
                <button class="btn-gen" type="submit">
                    CREAR ENCUENTRO
                </button>
            </div>
		</div>
	</div>
	</form>
</div>
@endsection
@section('scripts')
@endsection