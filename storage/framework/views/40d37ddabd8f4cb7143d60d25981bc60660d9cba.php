<?php $__env->startSection('content'); ?>
<div class="container pt-5 pb-2">
	<div class="row">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="#">Recursos y herramientas</a>
			</div>
			<p></p>
			<h1>Recursos y herramientas</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<p class="pt-3">Aquí encuentras recursos y herramientas que el ICBF y el Ministerio de Educación prepararon para enriquecer tu labor y tu formación. Puedes consultar, descargar y compartir esta información.</p>
			<p><strong>Para empezar selecciona la categoría de recursos que quieres explorar:</strong></p>
		</div>
	<div class="col-md-1">&nbsp;</div>
	<div class="col-md-5">
			<h4><strong>Búsqueda avanzada</strong></h4>
			<form method="GET" action="<?php echo e(route('resultado-busqueda-recursos')); ?>" class="pt-2">
				<?php echo csrf_field(); ?>                       
				<div class="form-group">
                    <input class="typeahead form-control" type="text" name="search_item" placeholder="Búsqueda por palabra clave o frase" required>
					<span class="help-block"></span>
				</div>
				<div class="text-right"><button class="btn-w" type="submit">BUSCAR</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="jumbotron mb-0 pb-0">
	<div class="container pb-0">
		<div class="row">
			<?php $__currentLoopData = $resourcesCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resourcesCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-md-4 text-center pb-5 pl-3 pr-3"><a href="/ver-categoria?categoria=<?php echo e($resourcesCategory->id); ?>"><img src="/images/bgprocesses/<?php echo e($resourcesCategory->id); ?>.png" class="img-fluid"><h4 class="colormain"><strong><?php echo e($resourcesCategory->name); ?></strong></h4></a><p><?php echo e($resourcesCategory->description); ?></p></div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <script type="text/javascript">
        var path = "<?php echo e(route('cpe.autocomplete')); ?>";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {
                    return process(data);
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/recursos.blade.php ENDPATH**/ ?>