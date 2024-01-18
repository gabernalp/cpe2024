<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card nobg nobr pb-0 mb-0">
        <div class="card-body mb-0 pb-0">
            <div><a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/registro">Registro</a></div>
            <p></p>
            <h1 class="pb-2">Registro</h1>
            <p></p>
            <div class="row">
                <div class="col-md-6"><p>¡Crea tu perfil para comenzar un ciclo de retos, conectarte con más personas en el país y acceder a todas las opciones que tenemos para ti!</p>
				<p><strong>*Si te conectaste previamente por Whatsapp, debes completar tu inscripción desde ese medio*</strong></p>

                </div>
                <div class="col-md-6"><?php if($message ?? ''): ?> <div class="alert alert-warning" role="alert">
                    <?php echo e($message ?? ''); ?>

                  </div> <?php endif; ?></div>
            </div>
        </div>
    </div>
    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo e(csrf_field()); ?>

        <?php if(isset($_GET['prog'])): ?>
        <input type="hidden" name="prog" value="<?php echo e($_GET['prog']); ?>">
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card nobg nobr">
                    <div class="card-body">
                        <div class="row">
							<div class="col-md-12">
								<label for="name">Nombres y apellidos</label>
								<div class="input-group mb-3">
								<input type="text" name="name" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" required autofocus placeholder="Nombres y apellidos" value="<?php echo e(old('name', null)); ?>">
								<?php if($errors->has('name')): ?>
									<div class="invalid-feedback">
										<?php echo e($errors->first('name')); ?>

									</div>
								<?php endif; ?>
								</div>			
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="documenttype_id">Tipo de documento</label>
								<div class="input-group mb-3">
									<select class="form-control<?php echo e($errors->has('documenttype_id') ? ' is-invalid' : ''); ?>" name="documenttype_id" id="documenttype_id" required autofocus>
                                        <?php $__currentLoopData = App\Models\DocumentType::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documenttype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($documenttype->id); ?>"><?php echo e($documenttype->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
									<?php if($errors->has('documenttype_id')): ?>
										<div class="invalid-feedback">
											<?php echo e($errors->first('documenttype_id')); ?>

										</div>
									<?php endif; ?>
								</div>	
							</div>
							<div class="col-md-6">
								<label for="document">Número de documento</label>
								<div class="input-group mb-3">
								<input type="number" name="document" class="form-control<?php echo e($errors->has('document') ? ' is-invalid' : ''); ?>" required autofocus placeholder="Sin puntos ni comas" value="<?php echo e(old('document', null)); ?>">
								<?php if($errors->has('document')): ?>
									<div class="invalid-feedback">
										<?php echo e($errors->first('document')); ?>

									</div>
								<?php endif; ?>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="phone">Telefono celular</label>
								<div class="input-group mb-3">
								<input type="tel" min="999999999" max="9999999999" name="phone" pattern="57[0-9]{3}[0-9]{3}[0-9]{4}" value="57" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" required autofocus>
								<?php if($errors->has('phone')): ?>
									<div class="invalid-feedback">
										<?php echo e($errors->first('phone')); ?>

									</div>
								<?php endif; ?>
                                <span class="help-block"><small class="colormain" style="font-size:0.75rem">Agrégalo despues del 57 Ejemplo: 573102223333</small></span>

								</div>	
							</div>
							<div class="col-md-6">
								<label for="email">Correo electrónico</label>
								<div class="input-group mb-3">
								<input type="email" name="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" required autofocus placeholder="Ej.nombre@correo.com" value="<?php echo e(old('email', null)); ?>">
								<?php if($errors->has('email')): ?>
									<div class="invalid-feedback">
										<?php echo e($errors->first('email')); ?>

									</div>
								<?php endif; ?>
								</div>	
							</div>
						</div>
                    </div>
                </div>
            </div>
			<div class="col-md-6 col-12">
                <div class="card nobg nobr">
                    <div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<label for="place_role">¿Dónde ejerces tu labor?*</label>
								<div class="input-group mb-3">
									<select class="form-control<?php echo e($errors->has('place_role') ? ' is-invalid' : ''); ?>" name="place_role" id="place_role" required autofocus>
                                       <option value disabled <?php echo e(old('place_role', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                        <?php $__currentLoopData = App\Models\User::PLACE_ROLE_SELECT; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>" <?php echo e(old('place_role', '') === (string) $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
									<?php if($errors->has('place_role')): ?>
										<div class="invalid-feedback">
											<?php echo e($errors->first('place_role')); ?>

										</div>
									<?php endif; ?>
								</div>	
							</div>
							<div class="col-md-6">
								<label for="labour_role">Rol</label>
								<div class="input-group mb-3">
									<select class="form-control<?php echo e($errors->has('labour_role') ? ' is-invalid' : ''); ?>" name="profile_id" id="profile_id" required autofocus>
										<option value disabled <?php echo e(old('profile_id', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                        <?php $__currentLoopData = App\Models\Profile::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>" <?php echo e(old('profile_id', '') === (string) $role->id ? 'selected' : ''); ?>><?php echo e($role->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
									<?php if($errors->has('profile_id')): ?>
										<div class="invalid-feedback">
											<?php echo e($errors->first('profile_id')); ?>

										</div>
									<?php endif; ?>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="department_id">Regional(departamento)</label>
								<div class="input-group mb-3">
									<select class="form-control<?php echo e($errors->has('department_id') ? ' is-invalid' : ''); ?>" name="department_id" id="department" required autofocus>
                                        <option value="">Por favor seleccione </option>
                                        <?php $__currentLoopData = App\Models\Department::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
									<?php if($errors->has('department_id')): ?>
										<div class="invalid-feedback">
											<?php echo e($errors->first('department_id')); ?>

										</div>
									<?php endif; ?>
								</div>	
							</div>
                            <div class="col-md-6">
                                <label for="city_id">Municipio donde laboras</label>
								<div class="input-group mb-3">
                                <select class="form-control <?php echo e($errors->has('city') ? 'is-invalid' : ''); ?>" name="city_id" id="city">
                                    </select>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="password">Contraseña</label>
								<div class="input-group mb-3">
									<input type="password" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" required >
									<?php if($errors->has('password')): ?>
										<div class="invalid-feedback">
											<?php echo e($errors->first('password')); ?>

										</div>
									<?php endif; ?>
								<span class="help-block"><small class="colormain" style="font-size:0.75rem">La contraseña debe tener al menos 8 caracteres y un número</small></span>
								</div>
							</div>
							<div class="col-md-6">
								<label for="password_confirmation">Confirmar Contraseña</label>
								<div class="input-group mb-4">
									<input type="password" name="password_confirmation" class="form-control" required>
								</div>	
							</div>
						</div>
						<div class="row pt-3">
							<div class="col-md-12">
								<div class="input-group mb-4">
									<input class="mt-1 pb-1" type="checkbox" required>&nbsp;Acepto los&nbsp; <a data-toggle="modal" data-target="#exampleModalLong" style="cursor: pointer"> <span class="colormain"> acuerdos de conducta </span></a>&nbsp;y los <a href="/terminos">&nbsp;términos de uso</a> 
								</div>	
							</div>
						</div>
						
						<button class="btn-gen" style="float: right">
                        CREAR CUENTA
                    	</button>
                    </div>
                </div>
            </div>
		</div>
    </form>
	<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title colormain" id="exampleModalLongTitle"><strong>Acuerdos de conducta</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Todos los espacios de conexión e interacción con otras personas que se programen a través de esta plataforma se regirán por los siguientes acuerdos básicos de conducta:</p>
		  1. Respetar el derecho a la palabra de las demás personas.<br />
		  2. Desempeñarse con imparcialidad y no tratar de manera preferente a ninguna persona.<br />
		  3. Dirigirse con respeto y con lenguaje apropiado a todas las personas.<br />
		  4. Usar el espacio únicamente con fines pedagógicos y de aprendizaje.<br />
		  5. Evitar cualquier actividad o pronunciamiento público que comprometa al Instituto Colombiano de Bienestar Familiar, sin el debido consentimiento de sus funcionarios.<br /><br />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    $("#department").change(function(){
        $.ajax({
            url: "<?php echo e(route('admin.cities.get_by_department')); ?>?department_id=" + $(this).val(),
            method: 'GET',
            success: function(data) {
                $('#city').html(data.html);
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/auth/register.blade.php ENDPATH**/ ?>