
<?php $__env->startSection('content'); ?>
<div id="infografia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="row m-0 pt-4 pr-4 pl-4">
			<div class="col-md-12">
                <img src="<?php echo e($tematica->imagen_especial->getUrl()); ?>" class="img-fluid">
			</div>
		</div>
		<div class="modal-footer">
		  	<button type="button" class="btn-w" data-dismiss="modal">Continuar</button>
		</div>
    </div>
  </div>
</div>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/ciclos-retos">Participar en ciclos de retos</a>» <a class="bcrumb" href="#">Temática</a>
			</div>
			<p></p>
			<h1><?php echo e($tematica->name); ?></h1>
		</div>
		<div class="col-md-6">&nbsp;</div>
	</div>
</div>

<div class="container pb-5">
	<?php
		$cuentaCiclos = 1;
	?>
	<div class="row">
		<div class="col-md-6">
            <p>Estos son los ciclos de retos disponibles según la temática que seleccionaste. <strong>Haz clic en el título</strong> del que más te llame la atención para ver los detalles e inscribirte. </p>
            <p class="colormain" style="cursor: pointer" data-toggle="modal" data-target="#infografia"><i class="fa fa-eye"></i> <strong>Ver la infografía acerca de esta estrategia</strong></p>
                <?php $__currentLoopData = $ciclosTema; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cicloTema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mb-3">
                        <div class="card-body p1r">
                            <h5 class="colormain">Ciclo No. <?php echo e($cuentaCiclos); ?></h5>
                            <p><a class="mainblue" href="/detalle-ciclo?ciclo=<?php echo e($cicloTema->id); ?>"><strong><?php echo e($cicloTema->name); ?></strong></a><br />
                            <small><strong>Tema: <?php echo e($tematica->name); ?></strong></small></p>
                            <?php if($ciclos->count() > 0): ?>
                            <small>Fechas de inicio:</small> 
                                <?php $__currentLoopData = $ciclos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ciclo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($ciclo->course_id == $cicloTema->id): ?>
                                        <small><?php echo e(fechaEs($ciclo->start_date)); ?></small>&nbsp;
                                    <?php endif; ?>                            
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <small class="colormain">¡Muy pronto nuevas fechas de programación!</small> 
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    $cuentaCiclos++;
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
		<div class="col-md-1">
			&nbsp;
		</div>
		<div class="col-md-5">
			<p>Busca más ciclos de retos si no encuentras uno de tu interés</p>
			<form method="POST" action="<?php echo e(route('cpe.resultado-busqueda-temas')); ?>" class="pt-1">
				<?php echo csrf_field(); ?>                       
				<div class="form-group">
					<input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-gen" type="submit">BUSCAR</button>
				</div>
			</form>
			<p class="pt-3">&nbsp;</p>
			<img class="img-fluid" src="/images/buscar.png" alt="Imagen lupa buscar">
		</div>
	</div>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $(document).ready(function(){
        $('#infografia').modal('show');
        }); 
    </script>>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/ciclos-de-retos-especiales.blade.php ENDPATH**/ ?>