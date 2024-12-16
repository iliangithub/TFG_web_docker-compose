<?php
session_start();

if (isset($_SESSION['valid_user'])) {
	include '../../PHP_comun/sesionname_variable.php';
	//include '../../PHP_comun/datos_conexion.php'; este NO hay que incluirlo, porque estoy abriendo la conexión ya desde el principio y eso no puede ser
	//se tiene que abrir cuando haga falta, no ya desde el princpio.

}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Sección de compras</title>
		<link rel="icon" type="image/x-icon" href="../../IMAGENES/fav.ico">
		<link rel="stylesheet" href="../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
		<link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
		<link rel='stylesheet' href='../../CSS_comun/caja_blanca_bordes.css'>
<?php
if (isset($_SESSION['valid_user'])) {
echo "	
		<link rel='stylesheet' href='comprar_cursos.css'>
		<link rel='stylesheet' href='../../CSS_comun/caja_blanca_bordes.css'>
		<link rel='stylesheet' href='../../CSS_comun/letrita_error.css'>

";
}else{
echo " 
		<link rel='stylesheet' href='../../CSS_comun/cuando_no_has_iniciado_sesion.css'>

";
}
?>
		<script src="../../JavaScript/desplegar_navegador_vertical.js"></script>
	</head>
	<body>
		<header>
			<nav>
            <button class='boton_hamburguesa_class' id='boton_hamburguesa_js' onclick='toggleMenu()'>☰</button>
            <button class='boton_cerrar_class' id='boton_x_js' onclick='closeMenu()'>✖</button>
				<ul>
					<li><a href="../canjeatucupon/canjea_tu_cupon.php">Canjea tu cupón</a></li>
					<li><a href="#">Cursos</a>
						<ul>
							<li><a href="../cursos/trading.php">Trading</a></li>
							<li><a href="../cursos/ecommence.php">eCommerce</a></li>
							<li><a href="../cursos/comprar_cursos.php">Comprar</a></li>	
						</ul>
					</li>
					<li><a href="../../index.php">Menú principal</a></li>
					<li><a href="../contacto/contacto.php">Contacto</a></li>

							<?php							
if (isset($_SESSION['valid_user'])) {							
echo "				<li><a href='#'>Usuario: " . $usuario_actual . "</a>
						<ul>
							<li> <a href='../iniciosesion/logout.php'>Cerrar sesión</a></li>
							<li> <a href='../usuario/configuracion.php'>Configuración</a></li>
							<li> <a href='../usuario/mi_carrito.php'>Mi Carrito 🛒</a></li>
							<li> <a href='../usuario/mis_cursos.php'>Mis cursos</a></li>
							<li> <a href='../usuario/ver_mi_cartera.php'>Ver mi cartera</a></li>
						</ul>
					</li>
				</ul>      
			</nav>
		</header>
		<main>";//main contendrá TODO

	/*AQUI VOY A HACER UN IF, EN CASO DE QUE TENGA NOMBRE, APELLIDOS, ETC... QUE ME MUESTRE PARA RELLENAR EL CUPON*/

	include '../../PHP_comun/datos_conexion.php';

	$consulta_datos_personales = mysqli_prepare($conexion, "SELECT nombre, primerapellido, segundoapellido, prefijo_telefono, telefono, direccion FROM usuarios WHERE usuario = ?");
	mysqli_stmt_bind_param($consulta_datos_personales, "s", $usuario_actual);
	mysqli_stmt_execute($consulta_datos_personales);
	mysqli_stmt_bind_result($consulta_datos_personales, $nombre, $primerapellido, $segundoapellido, $prefijo, $telefono, $direccion);
	mysqli_stmt_fetch($consulta_datos_personales);
	mysqli_stmt_close($consulta_datos_personales);
	mysqli_close($conexion);

		
		if ($nombre != NULL && $primerapellido != NULL && $segundoapellido != NULL && $telefono != NULL && $direccion != NULL && $prefijo != NULL) {
			/* ====================================== en caso de que tengas todos los datos introducidos ================================================*/
			include '../../PHP_comun/datos_conexion.php';
			echo "<form action='comprar_cursos.php' method='post'>";
			$consulta_todos_los_cursos_trading_QUE_NO_TIENE = mysqli_prepare($conexion, "SELECT curso, id_curso, precio FROM cursos WHERE NOT EXISTS (SELECT * FROM comprados INNER JOIN usuarios ON comprados.id_usuario_comprado_fk = usuarios.id_usuario WHERE cursos.id_curso = comprados.id_curso_comprado_fk AND usuarios.usuario = ?) AND NOT EXISTS (SELECT * FROM carrito_compra INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE cursos.id_curso = carrito_compra.id_curso_fk AND usuarios.usuario = ?) AND cursos.tipo = ?");
				$palabra_trading = 'trading';
				mysqli_stmt_bind_param($consulta_todos_los_cursos_trading_QUE_NO_TIENE, "sss", $usuario_actual, $usuario_actual, $palabra_trading);
				mysqli_stmt_execute($consulta_todos_los_cursos_trading_QUE_NO_TIENE);
				mysqli_stmt_store_result($consulta_todos_los_cursos_trading_QUE_NO_TIENE);
				
				mysqli_stmt_bind_result($consulta_todos_los_cursos_trading_QUE_NO_TIENE, $curso, $id_curso, $precio);

			$consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE  = mysqli_prepare($conexion, "SELECT curso, id_curso, precio FROM cursos WHERE NOT EXISTS (SELECT * FROM comprados INNER JOIN usuarios ON comprados.id_usuario_comprado_fk = usuarios.id_usuario WHERE cursos.id_curso = comprados.id_curso_comprado_fk AND usuarios.usuario = ?) AND NOT EXISTS (SELECT * FROM carrito_compra INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE cursos.id_curso = carrito_compra.id_curso_fk AND usuarios.usuario = ?) AND cursos.tipo = ?");
				$palabra_ecommerce = 'ecommerce';
				mysqli_stmt_bind_param($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE, "sss", $usuario_actual, $usuario_actual, $palabra_ecommerce);
				mysqli_stmt_execute($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE);
				mysqli_stmt_store_result($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE);
				
				mysqli_stmt_bind_result($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE, $curso, $id_curso, $precio);


				if (mysqli_stmt_num_rows($consulta_todos_los_cursos_trading_QUE_NO_TIENE) > 0 || mysqli_stmt_num_rows($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE) > 0) {
					
					if (mysqli_stmt_num_rows($consulta_todos_los_cursos_trading_QUE_NO_TIENE) > 0) {
						echo "<h1>🚀Estos son los cursos de Trading que están disponibles para ti: </h1>
							<div class='div_grid_texto_y_imagen'>
								<div class='solo_mediaquery_justificar'>
									¡Prepárate para adentrarte en el fascinante mundo del trading con uno de los expertos más reconocidos en la industria!<br>
									Javier Ibáñez te guiará a lo largo de este completo programa diseñado para llevar tus habilidades de trading al siguiente nivel.<br>
									<p>
									En este programa, no solo aprenderás los fundamentos esenciales del trading, sino que también te sumergirás en conceptos avanzados
									y estrategias probadas que te permitirán enfrentar los desafíos del mercado con confianza y conocimiento.
									</p>
									<p>
									Desde el análisis técnico hasta la gestión del riesgo y la psicología del trading, cada módulo está cuidadosamente diseñado
									para brindarte las herramientas necesarias para tomar decisiones informadas y ejecutar operaciones exitosas.
									</p>
									<p>
									Descubre cómo interpretar los movimientos del mercado, identificar oportunidades lucrativas y desarrollar un plan de trading <br>
									sólido que se adapte a tus objetivos y estilo personal.
									</p>
									
									¡Prepárate para transformar tu enfoque hacia el trading y alcanzar tus metas financieras con el Programa Avanzado de Trading con Javier Ibáñez!<br>
									
								</div>
								<div class='solo_para_mediaquery_centrar'>
									<div>
										<img class='imagen' src='../../IMAGENES/javier.png' width=200px>
										<div class='profesor_nombre'>Prof. Javier Ibánez<br>
										Máster Universitario en Finanzas
										</div>
									</div>
								</div>
							</div>";
					
						while (mysqli_stmt_fetch($consulta_todos_los_cursos_trading_QUE_NO_TIENE)) {
							echo "<div class='cursos'>" . $curso . " " . $precio . " € <input type='checkbox' name='id_de_checkbox[]' value='" . $id_curso . "'></div>";
						}
					}
				
					
					if (mysqli_stmt_num_rows($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE) > 0) {
						echo "<h1>🛒Estos son los cursos de eCommerce que están disponibles para ti:</h1>
							<div class='div_grid_texto_y_imagen'>
								<div class='solo_mediaquery_justificar'>
									🌐 Bienvenido a los Cursos de eCommerce con Ignacio Pedrosa Robles 📦<br>
									<p>
									¡Hola y bienvenido! Soy Ignacio Pedrosa Robles, y estoy encantado de acompañarte en tu viaje hacia el éxito en el mundo del comercio electrónico. <br>
									Sabemos que el eCommerce es una de las industrias más dinámicas y de rápido crecimiento en la actualidad, y queremos ayudarte a aprovechar todo su potencial.
									Nuestros cursos están diseñados pensando en ti, el emprendedor apasionado que quiere llevar su negocio al siguiente nivel. <br>
									No importa si estás comenzando desde cero o si ya tienes experiencia en el sector, aquí encontrarás el conocimiento y las herramientas que necesitas para triunfar.
									</p>
									Juntos, exploraremos desde los fundamentos del eCommerce hasta las estrategias más avanzadas para optimizar tus ventas y fidelizar a tus clientes. <br>
									Aprenderás a crear y gestionar tu tienda online, a dominar el marketing digital, y a utilizar las últimas tecnologías para mejorar la experiencia de tus usuarios.
									
									Cada módulo está estructurado para ser práctico y aplicable, con ejemplos reales y casos de estudio que te ayudarán a entender cómo aplicar lo aprendido en tu propio negocio. <br>
									Estoy comprometido a proporcionarte una formación de calidad que te permita ver resultados tangibles y alcanzar tus objetivos.
									
									¡Prepárate para transformar tu negocio y alcanzar nuevas alturas con nuestros cursos de eCommerce!
								</div>
								<div class='solo_para_mediaquery_centrar'>
									<div>
										<img class='imagen' src='../../IMAGENES/ignacio.png' width=200px>
										<div class='profesor_nombre'>Prof. Ignacio Pedrosa Robles<br>
										Máster Universitario en Comercio Internacional
										</div>
									</div>
								</div>
							</div>
							";
							while (mysqli_stmt_fetch($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE)) {
								echo "<div class='cursos'>" . $curso . " " . $precio . " € <input type='checkbox' name='id_de_checkbox[]' value='" . $id_curso . "'></div>";
							}
					}

				mysqli_stmt_close($consulta_todos_los_cursos_ecommerce_QUE_NO_TIENE);
				mysqli_stmt_close($consulta_todos_los_cursos_trading_QUE_NO_TIENE);
				

				echo "	<div class='div_centrar_submit'>
							<p><input type=submit value='Comprar' class='boton_submit' name='comprar'></p>
						</div>
					</form>";//y no hace falta poner el main, porque ya lo estoy cerrando abajo del todo...
				}else{//tengo que cerrar aqui para que en caso de tener TODOS los cursos comprados pues me quite el formulario y el botón
					echo "Parece que tienes TODOS los cursos de trading y ecommerce comprados. ¡Muchas gracias por el apoyo! 🥳🥳🥳
					<div class='agradecimiento_centrar'>
						<img src='../../IMAGENES/gato.gif'>
					</div>
					";
				}
			mysqli_close($conexion);
		}elseif ($nombre == NULL || $primerapellido == NULL || $segundoapellido == NULL || $telefono == NULL || $direccion == NULL || $prefijo == NULL) {
			/* ====================================== en caso de que te FALTE ALGÚN DATO ================================================*/
			echo   "
					<h2>Antes de poder comprar, necesitamos que rellenes estos datos: </h2>
					<form method='post' action='comprar_cursos.php'>";
			/*===========ahora vamos individualmente en caso de que te falte algo más concreto ===========*/
			if ($nombre == NULL) {
				echo "<section><div class='centrar_verticalmente_texto'>Nombre: </div><div><input type='text' name='input_nombre' class='texto_input'  maxlength='30' minlength='3' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'></div></section>";
			}else{
				echo "<section><div class='tipo_dato_subrayado'>Nombre: </div><div> ". $nombre ."</div></section>";
			}
	
			if ($primerapellido == NULL) {
				echo "<section><div class='centrar_verticalmente_texto'>Primer apellido: </div><div><input type='text' name='input_primerapellido' class='texto_input' maxlength='30' minlength='3' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'></div></section>";
			}else{
				echo "<section><div class='tipo_dato_subrayado'>Primer apellido: </div><div> ". $primerapellido ."</div></section>";
			}
	
			if ($segundoapellido == NULL) {
				echo "<section><div class='centrar_verticalmente_texto'>Segundo apellido: </div><div><input type='text' name='input_segundoapellido' class='texto_input' maxlength='30' minlength='3' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'></div></section>";
			}else{
				echo "<section><div class='tipo_dato_subrayado'>Segundo apellido: </div><div> ". $segundoapellido ."</div></section>";
			}
	
			if ($telefono == NULL) {
				echo "<section><div class='centrar_verticalmente_texto'>Teléfono: </div><div><input type='text' name='input_telefono' class='texto_input' minlength='7' maxlength='14' pattern='[0-9]{7,14}'></div></section>";
			}else{
				echo "<section><div class='tipo_dato_subrayado'>Teléfono: </div><div> ". $telefono ."</div></section>";
			}
	
			if ($prefijo == NULL) {
				echo "<section><div class='centrar_verticalmente_texto'>Prefijo: </div><div><input type='text' name='input_prefijo' class='texto_input' placeholder='Utilice el +, por ej: +34'  minlength='2' maxlength='4' pattern='[0-9+]{2,4}'></div></section>";
			}else{
				echo "<section><div class='tipo_dato_subrayado'>Prefijo: </div><div> ". $prefijo ."</div></section>";
			}
	
			if ($direccion == NULL) {
				echo "<section><div class='centrar_verticalmente_texto'>Dirección: </div><div><input type='text' name='input_direccion' class='texto_input' pattern='^[a-zA-Z0-9 íÍéÉáÁóÓúÚçÇñÑ]{4,50}$'></div></section>";
			}else{
				echo "<section><div class='tipo_dato_subrayado'>Dirección: </div><div> ". $direccion ."</div></section>";
			}
			echo   "
					<section class='flexbox_centrar_boton'>
						<input type='submit' name='anadir_datos' value='enviar'>
					</section>
					</form>";
		}

		if (isset($_POST['anadir_datos'])) { // para añadir datos NO CUPONES

			include '../../PHP_comun/datos_conexion.php';
		  
			if (isset($_POST['input_nombre'])) {
			//si existe el input que haga X, en caso de QUE NO APAREZCA EL INPUT no isset...
				$nombre = $_POST['input_nombre'];
		
				if ($nombre != NULL) {
					// ahora, existe el boton, pero si no pones nada dentro que no hague nada, y si NO está vacio que hague esto:
					$insertar_nombre= mysqli_prepare($conexion, "UPDATE usuarios SET nombre = ? WHERE usuario = ?");
					mysqli_stmt_bind_param($insertar_nombre, "ss", $nombre,$usuario_actual);
					mysqli_stmt_execute($insertar_nombre);
					mysqli_stmt_close($insertar_nombre);
			
				}  
			}
		
			if (isset($_POST['input_primerapellido'])) {
			//si existe el input, que haga X, en caso de QUE NO APAREZCA EL INPUT no isset... y no hará lo de dentro
		
				$primer_apellido = $_POST['input_primerapellido'];
		
				if ($primer_apellido != NULL) {
				// ahora, existe el boton, pero si no pones nada dentro que no hague nada, y si NO está vacio que hague esto:
					$insertar_primer_apellido = mysqli_prepare($conexion, "UPDATE usuarios SET primerapellido = ? WHERE usuario = ?");
					mysqli_stmt_bind_param($insertar_primer_apellido, "ss", $primer_apellido,$usuario_actual);
					mysqli_stmt_execute($insertar_primer_apellido);
					mysqli_stmt_close($insertar_primer_apellido);
			
				}   
			}
		
			if (isset($_POST['input_segundoapellido'])) {
				$segundo_apellido = $_POST['input_segundoapellido'];
		
				if ($segundo_apellido != NULL) {
					// ahora, existe el boton, pero si no pones nada dentro que no hague nada, y si NO está vacio que hague esto:
					$insertar_segundo_apellido = mysqli_prepare($conexion, "UPDATE usuarios SET segundoapellido = ? WHERE usuario = ?");
					mysqli_stmt_bind_param($insertar_segundo_apellido, "ss", $segundo_apellido,$usuario_actual);
					mysqli_stmt_execute($insertar_segundo_apellido);
					mysqli_stmt_close($insertar_segundo_apellido);
			
				}   
			}
		
			if (isset($_POST['input_telefono'])) {
				$telefono = $_POST['input_telefono'];
		
				if ($telefono != NULL) {
					// ahora, existe el boton, pero si no pones nada dentro que no hague nada, y si NO está vacio que hague esto:
					$insertar_telefono = mysqli_prepare($conexion, "UPDATE usuarios SET telefono = ? WHERE usuario = ?");
					mysqli_stmt_bind_param($insertar_telefono, "ss", $telefono,$usuario_actual);
					mysqli_stmt_execute($insertar_telefono);
					mysqli_stmt_close($insertar_telefono);
			
				} 
			}
		
			if (isset($_POST['input_prefijo'])) {
				$prefijo = $_POST['input_prefijo'];
		
				if ($prefijo != NULL) {
					// ahora, existe el boton, pero si no pones nada dentro que no hague nada, y si NO está vacio que hague esto:
					$insertar_prefijo = mysqli_prepare($conexion, "UPDATE usuarios SET prefijo_telefono = ? WHERE usuario = ?");
					mysqli_stmt_bind_param($insertar_prefijo, "ss", $prefijo,$usuario_actual);
					mysqli_stmt_execute($insertar_prefijo);
					mysqli_stmt_close($insertar_prefijo);
			
				} 
			}
		
			if (isset($_POST['input_direccion'])) {
				$direccion = $_POST['input_direccion'];
		
				if ($direccion != NULL) {
					// ahora, existe el boton, pero si no pones nada dentro que no hague nada, y si NO está vacio que hague esto:
					$insertar_direccion = mysqli_prepare($conexion, "UPDATE usuarios SET direccion = ? WHERE usuario = ?");
					mysqli_stmt_bind_param($insertar_direccion, "ss", $direccion,$usuario_actual);
					mysqli_stmt_execute($insertar_direccion);
					mysqli_stmt_close($insertar_direccion);
			
				} 
			}
			echo "<script>
				history.replaceState(null,null,location.pathname);
				location.reload();
				
				</script>";
		
				mysqli_close($conexion);
		}

		if (isset($_POST['comprar'])) {
		
			if (isset($_POST['id_de_checkbox'])) {
				$id_checkbox = $_POST['id_de_checkbox'];
	
				include '../../PHP_comun/datos_conexion.php';
	
				$id_del_usuario = mysqli_query($conexion, "SELECT id_usuario FROM usuarios WHERE usuario = '$usuario_actual'");
	
				$resultado_id_usuario = mysqli_fetch_row($id_del_usuario); //NO HAY QUE HACER NINGUN WHILE, AHORA UN echo $resultado_id_usuario[0]
	
				$cantidad_de_valores_que_hay_en_checkbox = count($id_checkbox);
	
				for ($i=0; $i < $cantidad_de_valores_que_hay_en_checkbox; $i++) { 
					 //echo $id_checkbox[$i];
					 mysqli_query($conexion, "INSERT INTO `carrito_compra` (`id_curso_fk`, `id_usuario_fk`) VALUES ('$id_checkbox[$i]','$resultado_id_usuario[0]')");
					
				}
				mysqli_close($conexion);
				
				include '../../PHP_comun/script_java_formulario.php';
	
			}else{
				echo "<div class='codigo_de_error'>No has seleccionado ningún curso para comprar</div>";
			}
		
		}
		
		

	echo "</main>";
}else{
//===================================== esta parte es exclusiva de cuando NO SE INICE SESIÓN ========================================
echo				"<li><a href='../../PHP/iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
			</ul>
		 </nav>
	 </header>
<div class='contenedor_blanco_centrado_sin_inicio'>
	<div class='contenedor_texto_sin_inicio'>
		Antes de comprar nuestros cursos, necesitamos <br>
		que inicie sesión o se registre.
			 
		<div class='div_centrar_submit'>
			<a href='../iniciosesion/iniciosesionyregistro.php' class='boton_submit'>Haz click aquí</a>
		</div>
	</div>	 
</div>";

}
?>