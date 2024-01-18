<?php $__env->startSection('content'); ?>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div class="">
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/login">Iniciar sesión</a></a>
			</div>
			<p></p>
			<h1>¡Inicia sesión!</h1>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-5 p-0">
			<div class="card nobg nobr">
				<div class="card-body p-4">
					<p class="pb-2">Para ingresar indícanos tu numero de cédula y la  <br>contraseña que pusiste al registrarte en la plataforma.</p>
					<p><strong></strong></p>

					<?php if(session('message')): ?>
						<div class="alert alert-info" role="alert">
							<?php echo e(session('message')); ?>

						</div>
					<?php endif; ?>

					<form method="POST" action="<?php echo e(route('login')); ?>">
						<?php echo csrf_field(); ?>

						<p class="text-muted">Número de Cédula</p>

						<div class="input-group mb-2">

							<input id="document" name="document" type="number" class="form-control<?php echo e($errors->has('document') ? ' is-invalid' : ''); ?>" required autocomplete="document" autofocus placeholder="Sin puntos ni comas ni espacios" value="<?php echo e(old('document', null)); ?>">

							<?php if($errors->has('document')): ?>
								<div class="invalid-feedback">
									<?php echo e($errors->first('document')); ?>

								</div>
							<?php endif; ?>
						</div>
                        <p><small class="colormain">*Si ingresaste antes por WhatsApp <u>y no te has inscrito a un ciclo de retos</u>, digita aqui tu número de celular</small></p>

					    <p class="text-muted">Contraseña</p>

						<div class="input-group">

							<input id="password" name="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" required placeholder="<?php echo e(trans('global.login_password')); ?>">

							<?php if($errors->has('password')): ?>
								<div class="invalid-feedback">
									<?php echo e($errors->first('password')); ?>

								</div>
							<?php endif; ?>

						</div>

                        <p><small class="colormain">*Si ingresaste antes por WhatsApp, digita aqui tu número de celular</small></p>
                        <div class="row mt-4">
							<div class="col-6">
								<button type="submit" class="btn-gen">
									<?php echo e(trans('global.login')); ?>

								</button>
							</div>
						</div>
							<p class="pt-2"><small><a href="<?php echo e(route('password.request')); ?>">>> OLVIDÉ O QUIERO CAMBIAR MI CONTRASEÑA</a></small></p>
							<p class="pt-3 pb-2"><strong>Si todavía no te has unido, <a href="/register"> haz clic aquí para registrarte</a></strong></p>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-1">&nbsp;</div>
		<div class="col-md-6">
			<img class="img-fluid" src="/images/fortalecer-transparente.png" alt="Imagen fortalecer mi labor">
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/auth/login.blade.php ENDPATH**/ ?>