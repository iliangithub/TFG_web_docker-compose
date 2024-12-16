<?php
session_start();

if (isset($_SESSION['valid_user'])) {	
	include '../../PHP_comun/sesionname_variable.php';
}
?>

<!-- A ESTA PAGINA SOLO SE DEBE DE ACCEDER EN CASO DE QUE SE HA INICIADO SESION
DE NINGUNA OTRA FORMA, SI NO, NO TIENE SENTIENE SENTIDO
QUE EXISTA UNA PAGINA DE CONFIGURACION PARA LA CUENTA DEL USUARIO,
SI NI SI QUIERA HAS INICIADO SESION

HAY QUE QUITAR CUALQUIER FORMA DE ACCEDER A ELLA, A MENOS
QUE SEA CON LA CUENTA INICIADA 

SI VAS ABAJO DEL TODO, ENTENDERÁS PORQUE EL VALID USER MUESTRA TODO LA BARRA DE NAVEGACION Y TODO-->		
<?php							
if (isset($_SESSION['valid_user'])) {	

echo"
<html>
	<head>
		<meta charset='UTF-8'>
		<title>Usuario configuración</title>
		<link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
		<link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
		<link rel='stylesheet' href='../../CSS_comun/caja_blanca_bordes.css'>
		<link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
		<link rel='stylesheet' href='mis_cursos.css'>
		<script src='../../JavaScript/desplegar_navegador_vertical.js'></script>
	</head>
	<body>
		<header>
			<nav>
            <button class='boton_hamburguesa_class' id='boton_hamburguesa_js' onclick='toggleMenu()'>☰</button>
            <button class='boton_cerrar_class' id='boton_x_js' onclick='closeMenu()'>✖</button>
				<ul>
					<li><a href='../canjeatucupon/canjea_tu_cupon.php'>Canjea tu cupón</a></li>
					<li><a href='#'>Cursos</a>
						<ul>
							<li><a href='../cursos/trading.php'>Trading</a></li>
							<li><a href='../cursos/ecommence.php'>eCommerce</a></li>
							<li><a href='../cursos/comprar_cursos.php'>Comprar</a></li>
						</ul>
					</li>
					<li><a href='../../index.php'>Menú principal</a></li>
					<li><a href='../contacto/contacto.php'>Contacto</a></li>	
					<li><a href='#'>Usuario: " . $usuario_actual . "</a>
						<ul>
							<li> <a href='../iniciosesion/logout.php'>Cerrar sesión</a></li>
							<li> <a href='configuracion.php'>Configuración</a></li>
							<li> <a href='mi_carrito.php'>Mi Carrito 🛒</a></li>
							<li> <a href='mis_cursos.php'>Mis cursos</a></li>
							<li> <a href='../usuario/ver_mi_cartera.php'>Ver mi cartera</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</header>
		<div class='contenedor_blanco_centrado'>
			<div class='contenedor_texto'>
				<span class='titulo'>Tus cursos comprados: </span><br>";

include '../../PHP_comun/datos_conexion.php';

/*Como los nombres de usuario son únicos y no puedes registrarte con un nombre de usuario
que se repita, voy a buscar el id que corresponde al nombre*/


/*Quiero que se muestren los cursos del usuario que ha iniciado sesión, si tiene los muestra, si no, da un aviso*/
$consulta_cursos_trading_comprados = mysqli_query($conexion, "SELECT curso , fecha , hora FROM cursos JOIN comprados ON cursos.id_curso = comprados.id_curso_comprado_fk INNER JOIN usuarios ON comprados.id_usuario_comprado_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual' AND cursos.tipo = 'trading' ORDER BY cursos.id_curso ASC");
$consulta_cursos_ecommerce_comprados = mysqli_query($conexion, "SELECT curso , fecha , hora FROM cursos JOIN comprados ON cursos.id_curso = comprados.id_curso_comprado_fk INNER JOIN usuarios ON comprados.id_usuario_comprado_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual' AND cursos.tipo = 'ecommerce' ORDER BY cursos.id_curso ASC");

if (mysqli_num_rows($consulta_cursos_trading_comprados ) > 0 || mysqli_num_rows($consulta_cursos_ecommerce_comprados ) > 0) {
		
	
	if (mysqli_num_rows($consulta_cursos_trading_comprados ) > 0) {
		echo "<span class='subtitulo_subrayado'><p>Cursos de Trading adquiridos: </p></span>";

		while ($valores = mysqli_fetch_row($consulta_cursos_trading_comprados)) {
			echo  "<section class='grid_2'><div>". $valores[0] . "</div><div class='grid_parte_derecha_todo_derecha'> Comprado el dia ".$valores[1] . " a las " .$valores[2] . "</div></section>";
		}		
		
	}
	if (mysqli_num_rows($consulta_cursos_ecommerce_comprados ) > 0) {
		echo "<span class='subtitulo_subrayado'><p>Cursos de eCommerce adquiridos: </p></span>";
		while ($valores = mysqli_fetch_row($consulta_cursos_ecommerce_comprados)) {
			echo  "<section class='grid_2'><div>". $valores[0] . "</div><div class='grid_parte_derecha_todo_derecha'> Comprado el dia ".$valores[1] . " a las " .$valores[2] . "</div></section>";
		}		
		
	}

}else{
	echo "<p>¡Vaya!, parece que no tienes ningún curso comprado...</p>
	<div class='div_centrar_submit'><a class='boton_submit' href='../cursos/comprar_cursos.php'>Ir a la tienda de cursos</a></div>";

}
			
			
echo		"</div>
		</div>";
}else{
echo "

		<link rel='stylesheet' href='../../CSS_comun/cuando_entras_a_la_pagina_de_forma_ilegal.css'>
		<link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
	</head>
	<body>
		<span class='texto'>
		Puedes entrar a esta página solo si estás registrado o has iniciado sesión <br>
		Usted será redirigido a la de inicio de sesión, espere unos segundos
		</span>

		<script>
		function redirigir() {
			window.location.href = '../iniciosesion/iniciosesionyregistro.php';
		}

		setTimeout(redirigir, 3000);
		</script>
	</body>
</html>";
}
?>
