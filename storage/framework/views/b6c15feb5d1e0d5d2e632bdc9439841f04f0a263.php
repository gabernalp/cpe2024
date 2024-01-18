
<?php $__env->startSection('content'); ?>
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
    <?php if(env("OFERTAS") == 'encendido'): ?>
    <form action="<?php echo e(route('cpe.busquedaOfertas')); ?>" method="post">
    <?php echo csrf_field(); ?>
    
    <div class="row">
            <div class="col-lg-6 col-md-12 col-12 pr-5">
                <h5><strong>¡Bienvenidos!</strong></h5>
                <p>Agradecemos tu interés por participar en los procesos de formación y cualificación. Recuerda que estos procesos fortalecen las capacidades humanas a partir del reconocimiento de saberes, experiencias y competencias laborales para el mejoramiento de la calidad de los servicios de Educación Inicial del ICBF.</p>
                <p>Este año tendremos una oferta amplia de programas de formación y cualificación <strong>gratuitos</strong>.</p>


                    <p><strong>¡Participa y aprovecha esta gran oportunidad!</strong><br />Para acceder a nuestra oferta <strong>PREINSCRÍBETE</strong> en el siguiente formulario diligenciando y seleccionando tus datos. Proporciona información actualizada para contactarnos contigo:</p>
                    <div class="form-group">
                        <label class="required" for="department_id"><?php echo e(trans('cruds.user.fields.department')); ?></label>
                        <select required class="form-control <?php echo e($errors->has('department') ? 'is-invalid' : ''); ?>" name="department_id" id="department_id">
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('department_id') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('department')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('department')); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.user.fields.department_helper')); ?></span>
                    </div>
                    <div class="form-group">
                    <label class="required" for="entidad_asociada_id">Entidad a la que perteneces</label>
                        <select class="form-control <?php echo e($errors->has('entidad_asociada') ? 'is-invalid' : ''); ?>" name="entidad_asociada_id" id="entidad_asociada_id">
                            <?php $__currentLoopData = $entidad_asociadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('entidad_asociada_id') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('entidad_asociada')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('entidad_asociada')); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.profile.fields.entidad_asociada_helper')); ?></span>
                    </div>
                    <div class="form-group" id ="profileIcbf" style="display: none">
                        <label class="required" for="profile_id">Tu cargo es:</label>
                        <select class="form-control <?php echo e($errors->has('profile') ? 'is-invalid' : ''); ?>" name="profile_id" id="profile_id">
                            <?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(old('profile_id') == $id ? 'selected' : ''); ?>><?php echo e($entry); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('profile')): ?>
                            <div class="invalid-feedback">
                                <?php echo e($errors->first('profile')); ?>

                            </div>
                        <?php endif; ?>
                        <span class="help-block"><?php echo e(trans('cruds.user.fields.profile_helper')); ?></span>
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
    <?php else: ?>
    <h3>No hay ofertas disponibles en este momento.</h3>
    <?php endif; ?>
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
            <?php
              $i=1;
            ?>
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="carousel-item <?php if($i == 1): ?><?php echo e('active'); ?><?php endif; ?>">
              <a href="<?php echo e($banner->link); ?>" target="_blank"><img class="d-block w-100" src="<?php echo e($banner->image->getUrl()); ?>" alt="<?php echo e($banner->name); ?>"></a>
            </div>
            <?php
              $i = $i+1;
            ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/ofertas-formacion.blade.php ENDPATH**/ ?>