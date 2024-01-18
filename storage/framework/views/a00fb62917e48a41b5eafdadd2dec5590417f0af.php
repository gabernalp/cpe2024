

<?php $__env->startSection('content'); ?>
<div class="container pt-5 pb-2">
	<div class="row pb-4">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/recursos">Recursos y herramientas </a>» <a class="bcrumb" href="#">Recursos de la subcategoría</a>
			</div>
			<h1 class="pt-4"><?php echo e($subcategory->name ?? 'NombreSub'); ?></h1>
			<p class="pt-4">Acá puedes consultar todos los recursos disponibles para esta subcategoría. Haz clic sobre el título o el ícono para ver el archivo seleccionado. </p>
		</div>
	</div>
	<div class="row">
        <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($resource->file): ?>
            <?php
                $inforesult = $resource->file->mime_type;
                $expmime = explode("/",$inforesult);
                $imgbase = $expmime[0];
            ?>
            <div class="col-md-2 mb-2" id="myResource<?php echo e($resource->id); ?>">
                <p><?php if($resource->image_pdf): ?>
                        <a target="_blank" href="<?php echo e($resource->file->id); ?>"><img src="<?php echo e($resource->image_pdf->getUrl()); ?>" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small><?php echo e($resource->comments); ?></small>">
                        </a>
                    <?php else: ?>
                        <a target="_blank" href="<?php echo e($resource->file->getUrl()); ?>">
                        <img src="/images/<?php echo e($imgbase); ?>.png" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small><?php echo e($resource->comments); ?></small>">
                        </a>
                    <?php endif; ?></p>
                <p class="text-center"><?php if(Auth::check()): ?><i style="cursor: pointer" id="favorite<?php echo e($resource->id); ?>" class="fas fa-heart" data-toggle="tooltip" data-html="true" title="<small>Agregar a mi Biblioteca</small>"></i><input type="hidden" value="<?php echo e($resource->id); ?>" id="fav<?php echo e($resource->id); ?>"> <a target="_blank" href="<?php echo e($resource->file->getUrl()); ?>"><?php endif; ?><i class="fa fa-download"></i> <small>Descargar</small></a><br /><a target="_blank" href="<?php echo e(Storage::disk('public')->url('576/631669cfc37df_RETOUNICO1-TEMATICA4.pdf')); ?>"><small style="color: gray"><?php echo e($resource->name); ?></small></a><br />
                <?php if($resource->manual): ?>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-md-4"><a href="<?php echo e($resource->manual->getUrl()); ?>" target="_blank"><?php if($resource->image_manual): ?><img src="<?php echo e($resource->image_manual->getUrl()); ?>" class="img-fluid"><?php else: ?><img src="/images/<?php echo e($imgbase); ?>.png" class="img-fluid"><?php endif; ?></a></div>
                              <div class="col-md-8"><a href="<?php echo e($resource->manual->getUrl()); ?>" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso <?php echo e($resource->name); ?></a></div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
            </div>
            <p class="mb-2"></p>
            <?php elseif($resource->imagen_archivo): ?>
            <?php
                $inforesult = $resource->imagen_archivo->mime_type;
                $expmime = explode("/",$inforesult);
                $imgbase = $expmime[0];
            ?>
            <div class="col-md-2 mb-2" id="myResource<?php echo e($resource->id); ?>">
                <p><?php if($resource->image_pdf): ?>
                        <a  target="_blank" href="<?php echo e($resource->file->getUrl()); ?>"><img src="<?php echo e($resource->image_pdf->getUrl()); ?>" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small><?php echo e($resource->comments); ?></small>">
                        </a>
                    <?php else: ?>
                        <a  target="_blank" href="<?php echo e($resource->imagen_archivo->getUrl()); ?>">
                        <img src="/images/<?php echo e($imgbase); ?>.png" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small><?php echo e($resource->comments); ?></small>">
                        </a>
                    <?php endif; ?></p>
                <p class="text-center"><?php if(Auth::check()): ?><i style="cursor: pointer" id="favorite<?php echo e($resource->id); ?>" class="fas fa-heart" data-toggle="tooltip" data-html="true" title="<small>Agregar a mi Biblioteca</small>"></i><input type="hidden" value="<?php echo e($resource->id); ?>" id="fav<?php echo e($resource->id); ?>"> <a target="_blank" href="<?php echo e($resource->imagen_archivo->getUrl()); ?>"><?php endif; ?><i class="fa fa-download"></i> <small>Descargar</small></a><br /><a  target="_blank" href="<?php echo e($resource->imagen_archivo->getUrl()); ?>"><small style="color: gray"><?php echo e($resource->name); ?></small></a><br />
                <?php if($resource->manual): ?>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-md-4"><a href="<?php echo e($resource->manual->getUrl()); ?>" target="_blank"><?php if($resource->image_manual): ?><img src="<?php echo e($resource->image_manual->getUrl()); ?>" class="img-fluid"><?php else: ?><img src="/images/<?php echo e($imgbase); ?>.png" class="img-fluid"><?php endif; ?></a></div>
                              <div class="col-md-8"><a href="<?php echo e($resource->manual->getUrl()); ?>" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso <?php echo e($resource->name); ?></a></div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
            </div>
            <p class="mb-2"></p>
            <?php else: ?>
            <div class="col-md-2 mb-2" id="myResource<?php echo e($resource->id); ?>">
                <p class="text-center"><a target="_blank" href="<?php echo e($resource->link); ?>"><img title="<?php echo e($resource->comments); ?>" src="/images/link.png" class="img-fluid" alt=""></a></p>
                <p class="text-center"><?php if(Auth::check()): ?><i style="cursor: pointer" id="favorite<?php echo e($resource->id); ?>" class="fas fa-heart" data-toggle="tooltip" data-html="true" title="<small>Agregar a mi Biblioteca</small>"></i><input type="hidden" value="<?php echo e($resource->id); ?>" id="fav<?php echo e($resource->id); ?>"><?php endif; ?> <a  target="_blank" href="<?php echo e($resource->link); ?>"><i class="fa fa-link"></i> <small>Ir al recurso</small></a></p>
                <p class="text-center"><a  target="_blank" href="<?php echo e($resource->link); ?>"><small style="color: gray"><?php echo e($resource->name); ?></small></a><br />
                <?php if($resource->manual): ?>
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-md-4"><a href="<?php echo e($resource->manual->getUrl()); ?>" target="_blank"><?php if($resource->image_manual): ?><img src="<?php echo e($resource->image_manual->getUrl()); ?>" class="img-fluid"><?php else: ?><img src="/images/<?php echo e($imgbase); ?>.png" class="img-fluid"><?php endif; ?></a></div>
                              <div class="col-md-8"><a href="<?php echo e($resource->manual->getUrl()); ?>" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso <?php echo e($resource->name); ?></a></div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
            </div>
            <p class="mb-2"></p>
            <?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<script type="text/javascript">
    $("#favorite<?php echo e($resource->id); ?>").click(function(){
        $.ajax({
            url: "<?php echo e(route('admin.resources.favorite')); ?>?resource_id=<?php echo e($resource->id); ?>",
            method: 'GET',
            success: function(data) {
                alert('Recurso agregado exitosamente a tu biblioteca');
            }
        });
    });
</script>
<script type="text/javascript">
    $("#myResource<?php echo e($resource->id); ?>").click(function(){
        $.ajax({
            url: "<?php echo e(route('admin.resources.accessResource')); ?>?resource_id=<?php echo e($resource->id); ?>",
            method: 'GET',
            success: function(data) {
                
            }
        });
    });
</script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/ver-subcategoria.blade.php ENDPATH**/ ?>