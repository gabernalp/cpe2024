<?php $__env->startSection('content'); ?>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y encuentros</a> » <a class="bcrumb" href="#">Eventos institucionales</a>
			</div>
			<p></p>
			<h1>Memorias</h1>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-6">
			<p class="pt-3 pb-4">Acá puedes explorar las memorias de los eventos pasados de la Comunidad de Aprendizaje del ICBF. Son audios cortos en donde se resumen los principales aprendizajes del evento.</p>
			<img class="img-fluid" src="/images/luz_home_1.png" />
		</div>
		<div class="col-md-1">
			&nbsp;
		</div>
		<div class="col-md-5">
			<form method="POST" action="<?php echo e(route('resultado-busqueda-memorias')); ?>" class="pt-1">
				<?php echo csrf_field(); ?>                       
				<div class="form-group">
					<input placeholder="Búsqueda por palabra clave" class="form-control" type="text" name="name" id="name" value="" required="">
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-w" type="submit">BUSCAR</button>
				</div>
			</form>
			<?php if(count($events) > 0): ?>
			<?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="row pt-5">
			<div class="card mb-3 w100">
					<div class="card-body p1r">
						<p><small></strong><?php echo e($event->title); ?></strong></small><br />
						<?php if($event->date): ?>
							<small>Fecha: <?php echo e(fechaEs($event->date)); ?></small>
						<?php endif; ?>
						</p>
						<?php if($event->podcast): ?>
						<audio controls>
						  <source src="<?php echo e($event->podcast->getUrl()); ?>" type="<?php echo e($event->podcast->mime_type); ?>">
							Su navegador no soporta la reproducción de este tipo de archivo.
						</audio>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php else: ?>
			<div class="row">
				<p class="pt-3 colormain">No hay eventos futuros programados aún. Recuerda volver a esta sección periódicamente para enterarte de las nuevas programaciones y detalles.</p>
			</div>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="row" id="video"><img src="/images/separador.jpg" class="img-fluid"></div>
<div class="jumbotron bgw mb-0">
	<div class="container pt-3">
		<div class="row pt-3 pb-5">
			<div class="col-md-6">
				<h1 class="colormain">¿Te lo perdiste?</h1>
				<h4 class="colormain">Revisa la grabación del evento completo</h4>
			</div>
		</div>
		<div class="row">
			<?php if(count($events) > 0): ?>
				<?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-md-4 mb-3">
					<div class="video-responsive"><?php echo $event->video_embed; ?></div>
					<p class="pt-2"><small><strong><?php echo e($event->title); ?></strong><br />Fecha: <?php echo e($event->date); ?></small></p>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php else: ?>
				<div class="col-md-6">
					<p>No hay eventos para mostrar.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/memorias-grabaciones.blade.php ENDPATH**/ ?>