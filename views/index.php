<?php 
	require_once("../config/conexion.php");

	if(isset($_POST["enviar"]) and $_POST["enviar"]=="si"){

       require_once("../modelos/Usuarios.php");
       $usuario = new Usuario();
       $usuario->login();
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>inTi</title>
	<!-- Viewport para el Responsive design (Adaptable a Dispositivos moviles y tables) -->
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<!-- Normalize funciona como un reset para que se vea igual en cualquier navegador -->
	<link rel="stylesheet" href="../public/login/normalize.css" />
	<!-- Normalize funciona como un reset para que se vea igual en cualquier navegador -->
	<link rel="stylesheet" href="../public/login/fondo.css" />
	<link rel="stylesheet" href="../public/login/css/estilos.css" />
	<!---------------- Estas Son Las Fuentes ------------------>
	<link rel="stylesheet" href="../public/login/css/fontawesome-all.css">
	<link rel="stylesheet" href="../public/plugins/bootstrap/css/bootstrap.min.css">
	<!-- <link rel="stylesheet" href="./public/plugins/font-awesome/css/all.css"> -->
	<!---------------------- Favicon -------------------------->
	<link rel="icon" type="text/css" href="../public/login/img/logointi.png">
	<!--------------------- JavaScrip ------------------------->
	<script src="../public/login/js/pantallas.js"></script>
	<!-- <script src="../public/login/js/validacion.js"></script> -->
	<!-- <script src="js/formulario.js"></script> -->

</head>
<body>
<!---------------------------- Aqui Inicia El Fondo Slide ---------------------------->
	<div class="Principal">
		<div class="fondo">

			<ul class="slider">
				<li class="img1"></li>
				<li class="img2"></li>
				<li class="img3"></li>
			</ul>
		</div>
	 
<!------------------------------ Aqui Inicia El Banner ------------------------------>
		<div class="banner">
			<img src="../public/login/img/cintillo.jpg"> 
		</div>
		<!----------------------------------------------- Menu -------------------------------------------------->

		<div class="navegador">
			<ul class="menu-main">
				<li class="botones"><a class="botones" href="#"	onClick="muestra0()" ><i class="fas fa-home"></i>Inicio</a></li>
				<li class="botones"><a class="botones" href="#"	onClick="muestra1()" ><i class="fas fa-align-justify"></i>Misón</a></li>
				<li class="botones"><a class="botones" href="#"	onClick="muestra2()" ><i class="fas fa-eye"></i>Visión</a></li>
				<li class="botones"><a class="botones" href="#"	onClick="muestra3()" ><i class="fas fa-bullseye"></i>Objetivos</a></li>
				<li class="botones"><a class="botones" href="#"	onClick="muestra4()" ><i class="fas fa-sitemap"></i>Organigrama</a></li>
				<li class="botones"><a class="botones" href="#"	onClick="muestra5()" ><i class="fas fa-handshake"></i>Propósito</a></li>
				<li class="botones"><a class="botones" href="#"	onClick="muestra6()" ><i class="fas fa-balance-scale"></i>Legal</a></li>
			</ul>
		</div>
	<!--  -->
<!---------------------------------------------- Login -------------------------------------------------->

		<?php
            if(isset($_GET["m"])) {
           		switch($_GET["m"]){
               		case "1";
	               		?>
	               		<div class="alert alert-danger alert-dismissible">
	                      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                      	<h4><i class="icon fa fa-ban"></i> El correo y/o password es incorrecto o no tienes permiso!</h4>
	                	</div>
	                	<?php
	                	break;
                	case "2";
                		?>
                    	<div class="alert alert-danger alert-dismissible">
                      		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      		<h4><i class="icon fa fa-ban"></i> Los campos estan vacios</h4>         
		                </div>
		                <?php
		                break;
				}
         	}
        ?>

<!------------------------------------ Login ---------------------------------------->
		<div class="logo">
			<img src="../public/login/img/logointi.png" alt="" id="logooo">
		</div>
		<div class="login" id="login">

			<form action="" method="POST" id="formulario">
				<div class="usuario">
					<label>Correo: </label>
					<div class="group">
						<i class="fas fa-user"></i>
        				<input type="email" name="email" id="email" class="form-control" placeholder="" >
					</div>
				</div>
				<div class="usuario">
					<label>Contraseña: </label>
					<div class="group">
						<i class="fas fa-unlock"></i>
						<input type="password" name="password" id="password" class="form-control" placeholder="">
					</div>
				</div>
				<input type="hidden" name="enviar" class="form-control" value="si">

				<div class="forgot"> 					
					<button type="submit" id="enviar"><i class="fas fa-sign-in-alt"></i>Entrar</button>
					
				</div>
			</form>
		</div>
	</div>
	<!--------------------------------------------- Mision --------------------------------------------------->

		<div class="contenido" id="mision">
			<h1><i class="fas fa-align-justify"></i>Misión  inTi</h1>
				<ul>
					<li>Administrar y regular la posesión de las tierras de vocación agraria.</li>
					<li>Liderar la lucha contra el latifundio y contribuir a transformar las tierras bajo su administración en unidades socio–productivas eficientes.</li>
					<li>Promover y auspiciar la organización socio-productiva del campesinado, orientada al empoderamiento del Poder Popular Campesino.</li>
					<li>Garantizar a toda la familia campesina que lo requiera, un lote de tierras suficiente para trabajar.</li>
					<li>Promover las Comunas.</li>
				</ul>		
		</div>
<!------------------------------------------------ Vision ------------------------------------------------->

		<div class="contenido" id="vision">
			<h1><i class="fas fa-eye"></i>Visión inTi</h1>
				<br>
				<p>Garantizar a todas las familias campesinas tierras suficientes para progresar con dignidad, en el marco de un esquema de producción socialista que asegure la paz social en el campo e impulse la conquista de la Seguridad y Soberanía alimentaria.</p>
		</div>
<!----------------------------------------------- Objetivos ----------------------------------------------->

		<div class="contenido" id="objetivos">
			<h1><i class="fas fa-bullseye"></i>Objetivos Estrategicos</h1>
				<p> 	El área de Atención al Campesino se encarga de recibir las solicitudes de todos los procedimientos administrativos que se realizan en la Institución   (Regularización de Tierras, Revocatorias de los Instrumentos Agrarios que otorga la Institución, Desistimientos de solicitudes a nivel de sistema, Denuncias de Tierra Ociosas, Certificación de Fincas Productivas y Mejorables, remisión a las diferentes áreas que conforman esta Institución,  de acuerdo al estatus en el cual se encuentre el procedimiento administrativo iniciado, planificación de operativos de regularización de tierras a las comunidades o productores que se les dificulte el acceso a la Oficina Regional de Tierras (ORT), entrega de Títulos de adjudicación y Carta de Registro, Planificación de Operativos para la entrega de Títulos de Adjudicación de Tierras, Estudios Socio- económicos para los aspirantes a la adjudicación de lotes de terrenos rescatados, Atención de casos emblemáticos por parte del jefe de área) 
				</p>
		</div>
<!----------------------------------------------- Organigrama --------------------------------------------->

		<div class="organigrama1" id="organigrama">
			<div><img src="../public/login/img/organigrama.png" width="780" height="1000" r></div>
		</div>
<!------------------------------------------------ Propsito ----------------------------------------------->

		<div class="contenido" id="proposito">
			<h1><i class="fas fa-handshake"></i>Intencionalidad o Propósito</h1>
			<ul>
				<li>Rescatar las tierras propiedad del Instituto que se encuentren ocupadas ilegalmente.</li>
				<li>Recuperar o rescatar las tierras de vocación agraria que se encuentren ociosas, incultas o infrautilizadas.</li>
				<li>Declarar o negar la garantía de permanencia.</li>
				<li>Adjudicar las tierras a las campesinas y campesinos teniendo como sujeto prioritario la madre cabeza de familia y los jóvenes menores de 25 años.</li>
				<li>Clasificar las fincas, de acuerdo a su grado de aprovechamiento, en Productiva, Mejorable u Ociosa.</li>
				<li>Llevar el registro agrario de tierras y aguas.</li>
			</ul>
		</div>
<!------------------------------------------------ Legal -------------------------------------------------->

		<div class="contenido" id="legal">

			<h1><i class="fas fa-balance-scale"></i>Fundamentacion Legal</h1>
			<p>	El INTI es un ente autónomo adscrito al Ministerio del Poder Popular para la Agricultura y Tierras (MAT), cuya tarea primordial es contribuir con el desarrollo rural y agrario a través de una planificación estratégica, democrática y participativa sobre la tenencia de la tierra. Así lo establece el Decreto con Rango, Valor y Fuerza de Ley de Tierras y Desarrollo Agrario promulgado por el líder de la Revolución, Hugo Chávez Frías, el 10 de diciembre de 2001, y convertido en Ley de la República mediante modificaciones parciales en 2005 y 2010.</p><br>
			<p>Dicha Ley viene a dar operatividad concreta a las disposiciones constitucionales sobre desarrollo social en el medio rural. En este sentido, se prevé la eliminación íntegra del régimen latifundista, como sistema contrario a la justicia, al interés general y a la paz social en el campo.</p><br>
			<ul>
				<li><a class="link">Constitución de la República Bolivariana de Venezuela.</a></li>
				<li><a class="link">Desarrollo Económico y Social de la Nación 2007-2013</a></li>
				<li><a class="link">Ley de Tierras y Desarrollo Agrario</a></li>
				<li><a class="link">Ley de Soberanía Agroalimentaria</a></li>
				<li><a class="link">Ley del Banco Agrícola</a></li>
				<li><a class="link">Ley Orgánica de Procedimientos Administrativos</a></li>
				<li><a class="link">Ley de Simplificación de Trámites Administrativos</a></li>
				<li><a class="link">Ley de Crédito para el sector Agrario</a></li>
				<li><a class="link">Ley de Salud Agrícola Integral</a></li>
				<li><a class="link">Ley Orgánica de Ordenación del Territorio</a></li>
				<li><a class="link">Ley de Tierras Urbanas</a></li>
				<li><a class="link">Ley de Transporte Ferroviario Nacional</a></li>
				<li><a class="link">Ley de Demarcación y Garantía del Hábitat y Tierras de los Pueblos Indígenas</a></li>
			</ul>
		</div>
	</div>

	<!-- bootstrap 4.3.1 -->
	<script src="../public/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="../public/dist/js/plugins/bootstrap/js/bootstrap.min.js"></script>

	<!-- Font-Awesome -->
	<!-- <script src="../public/plugins/font-awesome/js/all.js"></script> -->
</body>
</html>