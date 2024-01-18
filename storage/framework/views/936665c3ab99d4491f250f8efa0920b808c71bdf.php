<?php $__env->startSection('content'); ?>
<div class="container pt-5 pb-3">
	<div class="row pb-4">
		<div class="col-md-12">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/mi-perfil">Mi Perfil</a></a>
			</div>
		</div>
	</div>
	<div class="row pb-5">
		<?php if(@$userApps->profile_pic): ?>
			<div class="col-md-2"><img class="myimg rounded-circle bgw" src="<?php echo e($userApps->profile_pic->getUrl()); ?>" /></div>
		<?php else: ?>
			<div class="col-md-2"><img class="myimg rounded-circle bgw" src="/images/profile-dummy.png" /></div>
		<?php endif; ?>
		<div class="col-md-8 col-10">
            <h1>¡Hola <?php echo e(auth()->user()->name); ?>!</h1>
            <p><?php if(auth()->user()->profile_id): ?><?php echo e(auth()->user()->profile->name); ?><?php endif; ?><br />
               <?php if(auth()->user()->department_id): ?><?php echo e(auth()->user()->department->name); ?><?php endif; ?> 
            </p>
            <p><a href="/editar-perfil" class="btn-gen">Editar mis datos</a></p>
		</div>
	</div>	
</div>
<div class="container pb-5">
  <div class="row">
    <div class="col-12">
		<section>
			<div class="card">
				<div class="card-header mb-0 pb-0">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item waves-effect waves-light">
				  <a class="nav-link active text-center" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false"><strong>Mis ciclos de retos</strong><br /><small>Fortalecer mi labor</small></a>
				</li>
				<li class="nav-item waves-effect waves-light">
				  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><strong>Mis encuentros</strong><br /><small>Aprender en comunidad</small></a>
				</li>
				<li class="nav-item waves-effect waves-light">
				  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="true"><strong>Mi biblioteca</strong><br /><small>Recursos y herramientas</small></a>
				</li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('educational_background_access')): ?>
                <li class="nav-item waves-effect waves-light">
				  <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="true"><strong>Recursos para coordinador</strong><br /><small>Ciclos de retos</small></a>
				</li>
                <?php endif; ?>
			  </ul>
				</div>
				<div class="card-body nobr">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade bgw active show" id="home" role="tabpanel" aria-labelledby="home-tab">
							<div class="row pt-4 ml-3">
								<div class="col-md-12">
									<h1>Mis ciclos de retos</h1>
									<h5 class="colormain">Participar en ciclos</h5>
								</div>	
							</div>
							<?php if(@$courses): ?>
							<div class="row pt-3 ml-3">
								<div class="col-md-6 mb-3">
									<p class="pt-4">
										En este espacio encuentras los ciclos de retos activos y ciclos de retos pasados. Haz click en el título del ciclo para ir al detalle o en el botón si esta activo.
									</p>
									<?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="card mb-3">
										<div class="card-body">
											<p><a href="mostrar-ciclo?ciclo=<?php echo e($course->id); ?>"><strong><?php echo e($course->course_name); ?></strong></a></p>
											<p class="pb-2"><strong>Tema: <?php echo e($course->course_schedule->course->tematica_asociada->name); ?></strong></p>
											<?php if($course->actual_challenge < 7): ?>
											<div style="float: right"><a class="btn-gen" href="mostrar-ciclo?ciclo=<?php echo e($course->id); ?>">ACTIVO</a></div>
											<?php else: ?>
											<div style="float: right"><a class="btn-gray" href="mostrar-ciclo?ciclo=<?php echo e($course->id); ?>">PASADO</a></div>
											<?php endif; ?>
										</div>
									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<div class="pt-4" style="text-align: center"><a href="/ciclos-retos" class="btn-w">Buscar un nuevo ciclo</a></div>
								</div>
								<div class="col-md-1 pt-2">
									&nbsp;
								</div>								
								<div class="col-md-5 pt-2">
									<img class="img-fluid" src="/images/fortalecer-transparente.png" alt="Imagen fortalecer mi labor">
								</div>
							</div>
							<?php else: ?>
							<div class="row pt-3 ml-3">
								<div class="col-md-6 mb-3">

									<p class="pt-4">
										<strong>¿Aún no has iniciado un ciclo de retos?</strong>
									</p>
									<p>
										Cada mes comenzamos distintos ciclos de retos, donde puedes fortalecer tu labor a través de ejercicios prácticos, cortos y flexibles. 
									</p>
									<p>
										Puedes escoger el tema en el que quieres fortalecerte, realizar los retos en tus tiempos y aplicar lo aprendido en tu día a día. Cada ciclo de retos dura 4 semanas.
									</p>
									<p class="pb-4">
										<strong>¡Inscribete ya!</strong>
									</p>
									<a href="/fortalecer-mi-labor" class="btn-w">Buscar un nuevo ciclo</a>
								</div>
								<div class="col-md-6 pt-2">
									<iframe  style="width:100%; height:auto; min-height: 315px" src="https://www.youtube.com/embed/ftYPWS_v1Fc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							</div>
							<?php endif; ?>
						</div>
						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							<div class="row pt-4 ml-3">
								<div class="col-md-6">
									<h1>Mis encuentros</h1>
									<h5 class="colormain">Aprender en comunidad</h5>
								</div>
							</div>
							<?php if((@$meetingsCount == 0) and (@$attendantsCount == 0)): ?>	
							<div class="row pt-3 ml-3">
								<div class="col-md-6 mb-3">

									<p class="pt-4">
										<strong>¿Aún no te has unido a los encuentros de práctica?</strong>
									</p>
									<p>
										Un encuentro de Práctica es un espacio de interacción de un grupo de personas con intereses afines que reflexionan sobre su práctica profesional, se apoyan y además construyen conjuntamente aprendizajes que les ayudan a desarrollarse y mejorar en su labor. 
									</p>
									<p>
										A partir de ahora podrás crear o asistir a encuentros, espacios donde vas a conocer personas de otras regiones para compartir y escuchar aprendizajes en grupos de hasta 10 integrantes.
									</p>
									<div class="row ml-0 mr-0 pt-3">
										<div class="col-md-6 pl-0 pb-3">
											<?php if(Auth::check()): ?>
												<a href="/crear-encuentro" class="btn-w w100 btn-block p-1 text-center">Crear un encuentro</a>
											<?php else: ?>
												<a href="/login" class="btn-w w100 btn-block p-1 text-center">Crear un encuentro</a>
											<?php endif; ?>
										</div>
										<div class="col-md-6 pl-0 pb-3">
												<a href="<?php echo e(env('APP_URL')); ?>/encuentros-practica#proximos" class="btn-w w100 btn-block p-1 text-center">Ver próximos encuentros</a>
										</div>				
									</div>
								</div>
								<div class="col-md-6 pt-2">
									<img class="img-fluid" src="/images/encuentrosw.jpg" alt="Imagen fortalecer mi labor">
								</div>
							</div>
							<?php else: ?>
							<div class="row ml-0 mr-0 pt-3">
								<div class="col-md-6">
								<?php if(count(@$meetingAttendants) > 0): ?>
                                    <p class="ml-3"><strong>Encuentros a los que he planeado asistir: (<?php echo e(count(@$meetingAttendants)); ?>)</strong></p>
									<?php $__currentLoopData = @$meetingAttendants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meetingAttendant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="col-md-12">
											<div class="card mb-3">
												<div class="card-body p1r">
													<div class="row">
														<div class="col-md-8">
															<p><strong><span class="colormain"><?php echo e($meetingAttendant->meeting->title); ?></span></strong><br />
															<small><strong>Encuentro creado por: </strong><?php echo e($meetingAttendant->meeting->user->name); ?>, <?php echo e($meetingAttendant->meeting->user->department->name ?? ''); ?></small><br />
															<small><strong>Propósito: </strong><?php echo e($meetingAttendant->meeting->description); ?></small><br />
															<small><strong>Metodología: </strong><?php echo e($meetingAttendant->meeting->methodology); ?></small><br />
															<small><strong>Fecha: </strong><?php echo e(fechaEs($meetingAttendant->meeting->date)); ?></small><br />
															<small><strong>Hora: </strong><?php echo e($meetingAttendant->meeting->time); ?> | <strong>Duración: </strong><?php echo e($meetingAttendant->meeting->meeting_term); ?> minutos</small><br />
														</div>
														<div class="col-md-4 pt-5 text-center">
															<?php if($meetingAttendant->meeting->date >= date("Y-m-d")): ?>
																<?php if($meetingAttendant->meeting->link): ?>
																	<a href="<?php echo e($meetingAttendant->meeting->link); ?>" class="btn-gen">Ingresar</a>
																<?php else: ?>
																	<a href="javascript:alert('Debes estar atento a la fecha y hora de este encuentro para asistir a través de este botón')" class="btn-gen">ACTIVO</a>
																<?php endif; ?>
															<?php else: ?>
																<a href="#" class="btn-gray">PASADO</a>
															<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>	
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?>
									<h5>No tienes encuentros a los que te hayas unido</h5>
									<a href="<?php echo e(env('APP_URL')); ?>/encuentros-practica#proximos" class="btn-w w100 btn-block p-1 text-center">Ver próximos encuentros</a>
								<?php endif; ?>
								</div>
								<div class="col-md-6">
                                    <p class="ml-3"><strong>Encuentros que he creado:</strong></p>
									<?php if(count($meetingsUser) > 0): ?>
									<?php $__currentLoopData = $meetingsUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="col-md-12">
											<div class="card mb-3">
												<div class="card-body p1r">
													<div class="row">
														<div class="col-md-8">
														<p><strong><span class="colormain"><?php echo e($meeting->title); ?></span></strong><br />
														<small><strong>Propósito: </strong><?php echo e($meeting->description); ?></small><br />
														<small><strong>Metodología: </strong><?php echo e($meeting->methodology); ?></small><br />
														<small><strong>Fecha: </strong><?php echo e(fechaEs($meeting->date)); ?></small><br />
														<small><strong>Hora: </strong><?php echo e($meeting->time); ?> | <strong>Duración: </strong><?php echo e($meeting->meeting_term); ?> minutos</small><br />

														</div>
														<div class="col-md-4 pt-5 text-center">
														<?php if($meeting->date >= date("Y-m-d")): ?>
															<?php if(@$meeting->link): ?>
																<a href="<?php echo e(@$meeting->link); ?>" class="btn-gen">Ingresar</a>
															<?php else: ?>
																<a href="javascript:alert('Debes estar atento a la fecha y hora de este encuentro para asistir a través de este botón')" class="btn-gen">ACTIVO</a>
															<?php endif; ?>
														<?php else: ?>
															<a href="#" class="btn-gray">PASADO</a>
														<?php endif; ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php else: ?>
									<p>No he creado encuentros hasta el momento</p>
									<?php endif; ?>
									<p class="pt-2"><a href="/crear-encuentro" class="btn-w w100 btn-block p-1 text-center">Crear un encuentro</a></p>
								</div>
							</div>
						<?php endif; ?>
						</div>
						<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
							<div class="row pt-4 ml-3">
							<div class="col-md-12">
								<h1>Mi biblioteca</h1>
								<h5 class="colormain">Recursos y herramientas</h5>
							</div>	
						</div>
						<div class="row pt-3 ml-3">
							<div class="col-md-6 mb-3">

								<p class="pt-4">
									<strong>Acá puedes ver todos los recursos que has consultado en el banco de recursos y herramientas de esta página.</strong>
								</p>
								<p class="pt-3">
									A partir de la próxima semana podrás ingresar al mundo de Recursos y herramientas y todos los recursos que consultes aparecerán en esta sección para que puedas encontrarlos más fácil y rápido la próxima vez que los necesites.
								</p>
                                <p class="colormain"><strong>Mis recursos destacados:</strong></p>
                                <?php $__currentLoopData = $userResources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userResource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p>· <?php if($userResource->resource->imagen_archivo): ?> 
                                        <?php echo e($userResource->resource->name); ?> <a  target="_blank" href="<?php echo e($userResource->resource->imagen_archivo->getUrl()); ?>"><i class="fa fa-download"></i> <small>Descargar</small></a> 
                                    <?php elseif($userResource->resource->file): ?>
                                        <?php echo e($userResource->resource->name); ?> <a  target="_blank" href="<?php echo e($userResource->resource->file->getUrl()); ?>"><i class="fa fa-download"></i> <small>Descargar</small></a>
                                    <?php else: ?>
                                        <?php echo e($userResource->resource->name); ?> <a target="_blank" href="<?php echo e($userResource->resource->link); ?>"> <i class="fa fa-link"></i> <small>Ir al recurso</small></a>
                                    <?php endif; ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<p class="text-center pt-3"><a href="/recursos" class="btn-w w100 p-1 btn-block text-center">Consultar recursos y herramientas</a></p>

							</div>
							<div class="col-md-6 pt-0">
								<img class="img-fluid" src="/images/recursos.png" alt="Imagen Recursos y herramientas">
							</div>
						</div>
						</div>
						<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('resources_download')): ?>
                        <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
							<div class="row pt-4 ml-3">
                                <div class="col-md-12">
                                    <h1>Archivos para descarga</h1>
                                    <h5 class="colormain">Ciclos de retos</h5>
                                </div>	
						    </div>
                            <div class="row">
                                <?php $__currentLoopData = $coordinatorCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coordinatorCourse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-12 ml-5"><?php echo e($coordinatorCourse->name); ?><br />
                                    <?php if($coordinatorCourse->imagen): ?>
                                    <a class="pl-2" href="<?php echo e($coordinatorCourse->imagen->getUrl()); ?>" target="_blank" style="display: inline-block">
                                        Descargar Archivo Imprimible
                                    </a>
                                    <?php endif; ?>
                                    <ul>
                                    <?php $__currentLoopData = (App\Models\Challenge::where('course_id',$coordinatorCourse->id)->get()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challengeCapsule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($challengeCapsule->capsule_file): ?>
                                        <li><a href="<?php echo e($challengeCapsule->capsule_file->getUrl()); ?>" target="_blank"><small>
                                        Descargar cápsula <?php echo e($challengeCapsule->name); ?></small></a></li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <ul></ul>
                                </div>
                                <hr />
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
						</div>
                    <?php endif; ?>
                </div>
				</div>
			</div>
		</section>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cpe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/cpe/mi-perfil.blade.php ENDPATH**/ ?>