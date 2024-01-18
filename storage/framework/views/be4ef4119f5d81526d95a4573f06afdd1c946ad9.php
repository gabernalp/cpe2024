<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel=icon type=image/png sizes=32x32 href=/images/favicon.png>
    <script src="<?php echo e(asset('js/front/5dc959b07a.js')); ?>" crossorigin="anonymous"></script>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Conectar para educar - Un programa que te ayudará a fortalecer tu labor en la educación inicial a los niños y niñas de Colombia!</title>
    <meta property="og:title" content="Conectar para Educar">
	<meta property="og:description" content="Fortalece tu labor en la educación inicial a los niños y niñas de Colombia">
	<meta property="og:image" content="images/logoseo.jpg">
	<meta property="og:url" content="<?php echo e(env('APP_UR')); ?>">
	<meta name="twitter:card" content="Conectar para Educar">
    <!-- Bootstrap -->
    <link href="<?php echo e(asset('css/bootstrap-4.4.1.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/dropzone.min.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(asset('js/jquery-3.4.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/front/bootstrap3-typeahead.min.js')); ?>"></script>
	<link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet" />

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-9KM91YKBLH"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-9KM91YKBLH');
	</script>
  </head>
  <body style="background-color: #FAF0F9">
    <div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-labelledby="modalAlertLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <?php if(session('error') != ''): ?>
                        <div class="text-center"><img src="/images/logoerror.png" style="max-width:160px" class="img-fluid"></div>
                    <?php else: ?>
                        <div class="text-center"><img src="/images/loglisto.png" style="max-width:160px" class="img-fluid"></div>
                    <?php endif; ?>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center"><?php if(session('message')): ?><?php echo session('message'); ?><?php else: ?><?php echo @$message; ?><?php endif; ?></p>
                </div>
                <?php if(session('share')): ?>
                <div class="modal-footer text-center">
                    <div class="modal-footer text-center">
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32">
                        <a class="a2a_dd" href="https://www.addtoany.com/share"><button class="btn btn-gen">COMPARTIR ENCUENTRO</button></a>
                        </div>
                        <script>
                        var a2a_config = a2a_config || {};
                        a2a_config.onclick = 1;
                        </script>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <nav class="navbar sticky-top navbar-expand-lg navbar-light bgw">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img class="imgnav d-none d-sm-none d-md-block" src="/images/logo_gobierno_de_colombia.png" alt="Logo Gobierno de Colombia">
            </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Quiero participar en
                     </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if(env('CICLOS') == 'encendido'): ?>
                        <a class="dropdown-item" href="/ciclos-retos">Ciclos de retos</a>
                        <?php else: ?>
                        <a class="dropdown-item" href="javascript:alert('En este momento no tenemos ciclos de retos disponibles.\r\nConsulta muy pronto en este menu nuevos ciclos de retos')">Ciclos de retos</a>               
                        <?php endif; ?>
                        <a class="dropdown-item " href="/eventos-encuentros">Eventos y encuentros</a>
                        <?php if(env('OFERTAS') == 'encendido'): ?>
                        <a class="dropdown-item" href="/ofertas-formacion">Ofertas de formación</a>
                        <?php else: ?>
                        <a class="dropdown-item" href="javascript:alert('En este momento no tenemos oferta disponible.\r\nConsulta muy pronto en este menu nuevos procesos de oferta')">Ofertas de formación</a>
                        <?php endif; ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/recursos">Recursos y herramientas</a>
                </li>
                <?php if(auth()->id()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/mi-perfil">Mi Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Salir
                    </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;"><?php echo csrf_field(); ?></form>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Iniciar sesión</a>
                </li>
                <?php endif; ?>
            </ul>

            <form class="form-inline my-2 my-lg-0">
                <img class="imgnav" src="/images/logo_icbf.png" alt="Logo ICBF">
            </form>
            </div>
        </div>
    </nav>
<?php echo $__env->yieldContent("content"); ?>
    <footer class="text-white text-lg-start footer">
        <!-- Grid container -->
        <div class="container p-4">
          <!--Grid row-->
          <div class="row">
            <!--Grid column-->
            <div class="col-lg-2 col-md-12 mb-4 mb-md-0 text-left footerbd">
                <div class="logog"><a href="https://www.gov.co" title="GOVCO" target="_blank"><img class="imglogog" alt="logo GOVCO" src="/images/logo_footer.png"></a></div>
                <div class="logo_co"><a href="https://www.colombia.co" title="Colombia" target="_blank"><img class="imglogoco" alt="logo CO Colombia" src="/images/logo_co_footer.png"></a></div>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0 footerbd">
                <h6 class="footerfont"><strong>Instituto Colombiano de Bienestar Familiar (ICBF) </strong></h6>
                <p class="footerbody">Dirección Sede de la Dirección General: Av. Carrera 68 # 64C - 75 Bogotá, Colombia.<br />
                Código Postal: 111061<br />NIT: 899999.239-2.<br />Horario de Atención: Lunes a viernes de 8:00 a.m. a 5:00 p.m.</p>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                <p class="footerbody">Conectar para Educar es una iniciativa de la Comisión Intersectorial para la Atención Integral de la Primera Infancia (CIPI), que ha contado con el liderazgo técnico de la Consejería Presidencial para la Niñez y la Adolescencia, el Ministerio de Educación Nacional (MEN) y el Instituto Colombiano de Bienestar Familiar (ICBF), con apoyo del Banco Interamericano de Desarrollo (BID).<br /><br />
                    Este portal web se encuentra en versión de prueba, por lo tanto, la dirección web y sus características funcionales son temporales. Y sus contenidos no representan la posición oficial de ninguna de las entidades participantes del proyecto. <br /><br />Puede contactarse, a través del operador de este proyecto WE PUSH SAS, al siguiente correo si necesita más información o si desea reportar dificultades con esta página: <br /><br /><a style="color:white" href="mailto:conectarparaeducar@wepush.co">conectarparaeducar@wepush.co</a><br />WhatsApp soporte: <a href="https://api.whatsapp.com/send?phone=+57<?php echo e(env('TEL_SOPORTE')); ?>&text=Hola, necesito ayuda">+57<?php echo e(env('TEL_SOPORTE')); ?></a>
                    </p>
				<div class="logog" style="float: right"><a href="https://www.iadb.org/es" title="BID" target="_blank"><img class="imglogog" alt="logo BID" src="/images/logo_bid.png"></a></div>
            </div>
            <!--Grid column-->
          </div>
          <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
          © 2022 Copyright - Todos los derechos reservados - Gobierno de Colombia
        </div>
        <!-- Copyright -->
      </footer>
   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="<?php echo e(asset('js/popper.min.js')); ?>" ></script> 
	<script src="<?php echo e(asset('js/bootstrap-4.4.1.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/front/perfect-scrollbar.min.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/front/jszip.min.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/front/moment.min.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/front/bootstrap-datetimepicker.min.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/front/select2.full.min.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/front/dropzone.min.js')); ?>" ></script>
	<script src="<?php echo e(asset('js/main.js')); ?>" ></script>
    <?php echo $__env->yieldContent('scripts'); ?>
<!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            email: "<?php echo e(env('APP_CONTACTO')); ?>", // Email
            whatsapp: "+573214291003", // WhatsApp number
            call_to_action: "Envíanos un mensaje", // Call to action
            button_color: "#932C8B", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "email,whatsapp", // Order of buttons
            pre_filled_message: "hola", // WhatsApp pre-filled message
        };
        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
    <?php if((session('message')) or ($message ?? '')): ?>
		<script>
			$(document).ready(function(){
			$('#modalAlert').modal('show');
			}); 
		</script>
	<?php endif; ?>
	    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
  </body>
</html>
<?php /**PATH C:\inetpub\wwwroot\icbf\resources\views/layouts/cpe.blade.php ENDPATH**/ ?>