<?php $__env->startSection('content'); ?>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/eventos-encuentros">Eventos y encuentros</a> » <a class="bcrumb" href="#">Eventos institucionales</a>
			</div>
			<p></p>
			<h1>Eventos institucionales</h1>
			<p></p>
		</div>
	</div>
</div>
<div class="container pb-5">
	<div class="row">
		<div class="col-md-6">
			<p class="pt-3">Acá vas a encontrar la lista de los próximos eventos institucionales del ICBF y del Ministerio de Educación.</p>
		</div>
	</div>
	<div  class="row">
		<?php if(count($events) > 0): ?>
			<?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="col-md-6">
				<div class="card mb-3">
					<div class="card-body p1r">
						<p><strong class="colormain">Comunidad de Aprendizaje</strong><br />
						<small><strong>Tema: <?php echo e($event->title); ?></strong></small></p>
						<p><small><?php echo $event->description; ?></small></p>
						<?php if($event->date): ?>
							<?php
								$fecha = Carbon\Carbon::parse($event->date);
							?>
							<p><small>Fecha: <?php echo e($fecha->toFormattedDateString()); ?></small></p>
						<?php endif; ?>
						<?php if($event->link): ?>
							<p><a target="_blank" href="<?php echo e($event->link); ?>" class="colormain"><small><strong>Acceder al evento</strong></small></a><br />
							<small class="colormain">*Accede al evento con este link el día y a la hora del evento</small></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php else: ?>
		<div class="col-md-6">
			<p class="pt-3 colormain">No hay eventos futuros programados aún. Recuerda volver a esta sección periódicamente para enterarte de las nuevas programaciones y detalles.</p>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/eventos-institucionales.blade.php ENDPATH**/ ?>