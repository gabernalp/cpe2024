@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-3">
	<div class="row pb-4">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/mi-perfil">Mi Perfil</a>» <a class="bcrumb" href="#">Ciclo de retos</a>
			</div>
		</div>
	</div>
	<div class="row pt-4 ml-3">
	</div>
	<div class="row pt-3 ml-3">
		<div class="col-md-6 mb-3">
			<h1>{{$course->course_schedule->course->name}}</h1>
			<p class="pt-4">
				<strong>Ciclo de retos activo</strong>
				<br/>Fecha de inicio: {{$course->course_schedule->start_date}}
			</p>
			<p class="pt-3">
				<strong>Tu progreso:</strong> {{count($challengesCount)}}/{{App\Models\Challenge::where('course_id',$course->course_schedule->course->id)->get()->count()}} retos completados <strong>Tu puntaje: </strong>{{count($challengesCount)*20}} puntos
			</p>
		</div>
		<div class="col-md-6 pt-0">
			<img class="img-fluid" src="/images/fortalecer-transparente.png" alt="Imagen Recursos y herramientas">
		</div>
	</div>	
</div>
<div class="container pb-5">
  <div class="row">
    <div class="col-12">
		<section>
			<div class="card">
				<div class="card-header mb-0 pb-0">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item waves-effect waves-light">
				  <a class="nav-link active text-center" id="home-tab" data-toggle="tab" href="#retos" role="tab" aria-controls="retos" aria-selected="false"><strong>Mis retos</strong></a>
				</li>
				<li class="nav-item waves-effect waves-light">
				  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#retroalimentaciones" role="tab" aria-controls="retroalimentaciones" aria-selected="true"><strong>Mensaje de cierre </strong></a>
				</li>
			  </ul>
				</div>
				<div class="card-body nobr">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade bgw active show" id="retos" role="tabpanel" aria-labelledby="home-tab">
							<div class="container d-flex mt-20">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
									<div class="tab-vertical">
										<ul class="nav nav-tabs" id="myTab3" role="tablist">
											@php
												$i = 0;
                                                $challengesCounter = count($challengesCount);
											@endphp
											@foreach($completed as $iteration)
											<li class="nav-item"> <a class="nav-link @php if ($i == $challengesCounter) echo 'active'; @endphp" id="{{$i}}-vertical-tab" data-toggle="tab" href="#vertical-{{$i}}" role="tab" aria-controls="{{$i}}" aria-selected="@php if ($i == 1) echo 'true'; else echo 'false'@endphp">{{$i+1}}</a> </li>
											@php
												$i = $i+1;
											@endphp
											@endforeach
										</ul>
										<div class="tab-content" id="myTabContent3" style="border: 1px solid #e2e0e1">
											@php
												$j = 0;
											@endphp
											@foreach($completed as $complete)
                                          <div class="tab-pane fade @php if ($j == $challengesCounter)  echo 'show active'; @endphp" id="vertical-{{$j}}" role="tabpanel" aria-labelledby="{{$j}}-vertical-tab">
												<div class="row p-0">
													<div class="col-md-6">														
														@if($course->actual_challenge > $j)
															<p class="lead colormain"><strong>Reto No. {{$j+1}}: {{$complete->name}}</strong></p>
															<p>{{$complete->goal}}</p>
															<p>Capsula de conocimiento:</p>
															<p><a href="{{$complete->capsule_file->getUrl()}}" target="_blank">Ver archivo de capsula</a></p>
															<p><strong>Instrucciones:</strong></p>
															<p>{!!$complete->action_detail!!}</p>
														@else
															<p>Este aun no se encuentra disponible</p>
														@endif
													</div>
													<div class="col-md-1">
														&nbsp;
													</div>
													<div class="col-md-5">
														<p><strong>Responder:</strong></p>
														@if($course->whatsapp_user == 1)
															Recuerda que decidiste utilizar <i class=" fa fa-whatsapp"></i><strong> WhatsApp</strong> como tu mecanismo para responder los retos.<br />Puedes acceder <a target="_blank" href="https://api.whatsapp.com/send?phone=57{{env('TEL_WHATSAPP')}}&text=responder">haciendo click aqui</a>
															<p class="pt-2">Si ya respondiste a este reto, podrás ver tu respuesta aqui:</p>
															@if($complete->reference_media)
																<p class="pt-3">{!! $complete->reference_media !!}</p>
															@endif
															@if($complete->reference_text)
																<p class="pt-3">{{$complete->reference_text}}</p>
															@endif
														@endif
														@if($userAnswer = App\Models\ChallengesUser::where('user_id',auth()->id())->where('challenge_id',$complete->id)->where('courseschedule_id',$course->course_schedule_id)->where('status','Recibido')->first())
															<p></p>Ya has respondido este reto.<br />
															<p>Esta fue tu respuesta:</p>
															@if($userAnswer->reference_text)
																<p>{{$userAnswer->reference_text}}</p>
															@endif
															@if($userAnswer->reference_media)
																<p>{!!$userAnswer->reference_media!!}</p>
															@endif
															@if($userAnswer->file)
																<p><a target="_blank" class="btn-gen" href="{{$userAnswer->file->getUrl()}}">Ver Archivo</a> <form action="{{env('APP_URL')}}/admin/challenges-users/{{$userAnswer->id}}" method="POST" onsubmit="return confirm('¿Estás seguro de querer cambiar tu respuesta?\r\nEsta acción NO se puede deshacer y anulara tu respuesta anterior');" style="display: inline-block;">
															@csrf
															<input type="hidden" name="_method" value="DELETE">
															<input type="submit" class="btn-w" value="Cambiar mi respuesta">
														</form></p>
															@endif
														@else
															@if($course->actual_challenge > $j)
																@if($course->whatsapp_user == 0)
																	<form method="POST" action="{{ route("admin.challenges-users.store") }}" enctype="multipart/form-data">
																	@csrf
																		<input type="hidden" name="status" value="Recibido">
																		<input type="hidden" name="user_id" value="{{auth()->id()}}">
																		<input type="hidden" name="challenge_id" value="{{$complete->id}}">
																		<input type="hidden" name="courseschedule_id" value="{{$course->course_schedule_id}}">

																	@if($complete->referencetype->name == 'texto')
																	<div class="form-group">
																		<label for="reference_text">{{ trans('cruds.challengesUser.fields.reference_text') }}</label>
																		<textarea class="form-control {{ $errors->has('reference_text') ? 'is-invalid' : '' }}" name="reference_text" id="reference_text">{{ old('reference_text') }}</textarea>
																		@if($errors->has('reference_text'))
																			<div class="invalid-feedback">
																				{{ $errors->first('reference_text') }}
																			</div>
																		@endif
																		<span class="help-block">{{ trans('cruds.challengesUser.fields.reference_text_helper') }}</span>
																	</div>
																	@else
																	<div class="form-group">
																		<label class="required" for="file">Archivo solicitado por el reto: </label>
																		<div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
																		</div>
																		@if($errors->has('file'))
																			<div class="invalid-feedback">
																				{{ $errors->first('file') }}
																			</div>
																		@endif
																		<span class="help-block">{{ trans('cruds.challengesUser.fields.file_helper') }}</span>
																	</div>
																	@endif
																	<div class="form-group">
																		<button class="btn btn-danger" type="submit">
																			{{ trans('global.save') }}
																		</button>
																	</div>
																	</form>
																@endif
														@endif
													@endif
													</div>
												</div>

											</div>
											@php
												$j = $j+1;
											@endphp
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="retroalimentaciones" role="tabpanel" aria-labelledby="contact-tab">
							<div class="row ml-0">
								<div class="col-md-6 pr-3">
                                    <img src="/images/diploma.jpg" class="img-fluid">
								</div>
								<div class="col-md-6 pl-3">
									<h4 class="colormain"><strong>Tu Mensaje de cierre</strong></h5>
									<hr />
									<p>{!!nl2br($course->course_schedule->course->mensaje_cierre)!!}</p>
									<p></p>
								</div>
							
							</div>

						</div>
<!--						<div class="tab-pane fade" id="reconocimiento" role="tabpanel" aria-labelledby="contact-tab">
							Reconocimiento
						</div>-->
			  		</div>
				</div>
			</div>
		</section>
    </div>
  </div>
</div>

@endsection
@section('scripts')
	<script>
		Dropzone.prototype.defaultOptions.dictDefaultMessage = "Arrastre aqui los archivos a cargar o haga click para buscar";
		Dropzone.prototype.defaultOptions.dictFallbackMessage = "Su navegador no ermite arrastrar archivos";
		Dropzone.prototype.defaultOptions.dictFileTooBig = "Archivo muy grande. Max tamano: 5MB.";
		Dropzone.prototype.defaultOptions.dictInvalidFileType = "No puede subir archivos de este tipo.";
		Dropzone.prototype.defaultOptions.dictCancelUpload = "Cancelar carga";
		Dropzone.prototype.defaultOptions.dictCancelUploadConfirmation = "Esta seguro de cancelar esta carga?";
		Dropzone.prototype.defaultOptions.dictRemoveFile = "Remover archivo";
		Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "No puede subir mas archivos.";
		Dropzone.options.fileDropzone = {
		url: 'https://conectarparaeducar.co/admin/challenges-users/media',
		maxFilesize: 20, // MB
		maxFiles: 1,
		addRemoveLinks: true,
		headers: {
		'X-CSRF-TOKEN': "{{ csrf_token() }}"
		},
		params: {
		size: 20
		},
		success: function (file, response) {
		$('form').find('input[name="file"]').remove()
		$('form').append('<input type="hidden" name="file" value="' + response.name + '">')
		},
		removedfile: function (file) {
		file.previewElement.remove()
		if (file.status !== 'error') {
		$('form').find('input[name="file"]').remove()
		this.options.maxFiles = this.options.maxFiles + 1
		}
		},
		init: function () {
		},
		error: function (file, response) {
		if ($.type(response) === 'string') {
			var message = response //dropzone sends it's own error messages in string
		} else {
			var message = response.errors.file
		}
		file.previewElement.classList.add('dz-error')
		_ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
		_results = []
		for (_i = 0, _len = _ref.length; _i < _len; _i++) {
			node = _ref[_i]
			_results.push(node.textContent = message)
		}

		return _results
		}
		}
	</script>
@endsection
