@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div class="">
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/login">Iniciar sesión usuarios Administrativos</a></a>
			</div>
			<p></p>
			<h1>¡Inicia sesión!</h1>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row justify-content-center">
		<div class="col-md-6 p-0">
			<div class="card nobg nobr">
				<div class="card-body p-4">
					<p class="pb-2">Ingrese con su nombre de Usuario MTS habilitado para la aplicación </p>
					<p><strong></strong></p>

					<form method="POST" action="{{ route('mts.validate') }}">
						@csrf

						<p class="text-muted">Nombre de usuario: Ej. JUAN.LOPEZ</p>

						<div class="input-group mb-2">

							<input id="username" name="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" required autocomplete="username" autofocus value="{{ old('username', null) }}">

							@if($errors->has('username'))
								<div class="invalid-feedback">
									{{ $errors->first('username') }}
								</div>
							@endif
						</div>

					    <p class="text-muted">Contraseña</p>

						<div class="input-group">

							<input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

							@if($errors->has('password'))
								<div class="invalid-feedback">
									{{ $errors->first('password') }}
								</div>
							@endif

						</div>
                        <div class="row mt-4">
							<div class="col-6">
								<button type="submit" class="btn-gen">
									{{ trans('global.login') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection