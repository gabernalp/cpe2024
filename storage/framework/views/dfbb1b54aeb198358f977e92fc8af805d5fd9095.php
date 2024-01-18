<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card nobg nobr pb-0 mb-0">
        <div class="card-body mb-0 pb-0">
            <div><a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="#">Editar perfil</a></div>
            <p></p>
            <h1 class="pb-2">Editar Perfil</h1>
            <p></p>
            <div class="row">
                <div class="col-md-6"><p>Actualiza los datos con la información mas reciente.</p>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="<?php echo e(route('cpe.actualizar-perfil')); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card nobg nobr">
                    <div class="card-body">
                        <div class="row">
							<div class="col-md-12">
								<label for="name">Nombres y apellidos</label>
								<div class="input-group mb-3">
								<input type="text" name="name" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" required autofocus placeholder="Nombres y apellidos" value="<?php echo e(auth()->user()->name); ?>">
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
                                            <option value="<?php echo e($documenttype->id); ?>" <?php if(auth()->user()->documenttype_id === $documenttype->id): ?> selected <?php endif; ?>><?php echo e($documenttype->name); ?></option>
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
                                    <?php if($message == ''): ?>
                                        <p class="pt-1 pb-1 pl-3 w-100" style="border: 1px solid #DCDCDC; border-radius:5px; background-color: lightgray"><?php echo e(auth()->user()->document); ?></p>
                                        <?php else: ?>
                                        <input class="form-control <?php echo e($errors->has('document') ? 'is-invalid' : ''); ?>" type="number" name="document" id="document" value="<?php echo e(old('document', auth()->user()->document)); ?>" step="1" required>
                                        <?php if($errors->has('document')): ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($errors->first('document')); ?>

                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>                                        

								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="phone">Telefono celular</label>
								<div class="input-group mb-3">
								<input type="number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="phone" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" required autofocus placeholder="Ejemplo: 3335557777" value="<?php echo e(substr(auth()->user()->phone,2,10)); ?>">
								<?php if($errors->has('phone')): ?>
									<div class="invalid-feedback">
										<?php echo e($errors->first('phone')); ?>

									</div>
								<?php endif; ?>
								</div>	
							</div>
							<div class="col-md-6">
								<label for="email">Correo electrónico</label>
								<div class="input-group mb-3">
								<input type="email" name="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" required autofocus placeholder="Ej.nombre@correo.com" value="<?php echo e(auth()->user()->email ?? ''); ?>">
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
                                            <option value="<?php echo e($key); ?>" <?php if(auth()->user()->place_role === (string) $key): ?>) selected <?php endif; ?>><?php echo e($label); ?></option>
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
								<label for="labour_role">Rol/cargo</label>
								<div class="input-group mb-3">
									<select class="form-control<?php echo e($errors->has('labour_role') ? ' is-invalid' : ''); ?>" name="profile_id" id="profile_id" required autofocus>
										<option value disabled <?php echo e(old('profile_id', null) === null ? 'selected' : ''); ?>><?php echo e(trans('global.pleaseSelect')); ?></option>
                                        <?php $__currentLoopData = App\Models\Profile::get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>" <?php if(auth()->user()->profile_id === $role->id): ?> selected <?php endif; ?>><?php echo e($role->name); ?></option>
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
                                            <option value="<?php echo e($department->id); ?>" <?php if(auth()->user()->department_id === $department->id): ?> selected <?php endif; ?>><?php echo e($department->name); ?></option>
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
                                    <option value="<?php echo e(auth()->user()->city_id  ?? ''); ?>"><?php echo e(auth()->user()->city->name ?? ''); ?></option>
                                    </select>
								</div>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="password">Contraseña</label>
								<div class="input-group mb-3">
									<input type="password" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" >
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
									<input type="password" name="password_confirmation" class="form-control">
								</div>	
							</div>
						</div>
						
						<button class="btn-gen" style="float: right">
                        EDITAR MIS DATOS
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
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/auth/edit.blade.php ENDPATH**/ ?>