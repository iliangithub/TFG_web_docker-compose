<?php
session_start();

require '../iniciosesion/vendor/autoload.php'; //para el composer

if (isset($_SESSION['valid_user'])) {
	include '../../PHP_comun/sesionname_variable.php';
}

//y así no hace falta incluirlo cada 2x3
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Contacto</title>
		
		<link rel="icon" type="image/x-icon" href="../../IMAGENES/fav.ico">
		<link rel="stylesheet" href="../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
<?php
if (isset($_SESSION['valid_user'])) {
echo "	<link rel='stylesheet' href='contacto.css'>";
}else{
echo "	<link rel='stylesheet' href='contacto_no_sesion.css'>
		<link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>";

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
						<ul class="submenu">
							<li><a href="../cursos/trading.php">Trading</a></li>
							<li><a href="../cursos/ecommence.php">eCommerce</a></li>
							<li><a href="../cursos/comprar_cursos.php">Comprar</a></li>							
						</ul>
					</li>
					<li><a href="../../index.php">Menú principal</a></li>
					<li><a href="contacto.php">Contacto</a></li>

<?php
if (isset($_SESSION['valid_user'])) {
echo "				<li><a href='#'>Usuario: " . $usuario_actual . "</a>
						<ul class='submenu'>
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
			<video autoplay loop muted playsinline class='background-video-contacto'>
				<source src='../../IMAGENES/contacto-bg.mp4' type='video/mp4'>
			</video>

		<main>
			<h2>Contacto</h2>
			<h1>¿Tienes una consulta?</h1>
			<h3>Conáctanos enviando un mensaje y te responderemos en breve</h3>
			
			<section class='grid_3_cuadrados'>
				<section>
					<h4>Nuetras Oficinas</h4>
					<h5>Calle San Millán, 12, Distrito Centro, <br>
					29013 Málaga
					</h5>
				</section>

				<section>
					<h4>¿Hablamos?</h4>
					<h5>
					staff-ventacursos@info.cursostfgcanovas.es
					</h5>
				</section>

				<section>
					<h4>Envíanos un mail</h4>
					<h5>
					service@info.cursostfgcanovas.es
					</h5>
				</section>
			</section>
			<div class='centrar'>
				<form action='contacto.php' method='post'>
					<div class='flexbox_centrar_grid'>
						<section class='grid_de_2'>
							<div class='input-container'>
								<input type='text' name='nombre' class='input1' minlength='3' maxlength='80' required placeholder=' ' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇ]{3,30}$'>
								<label for='nombre'>Nombre</label>
							</div>
							<div class='input-container'>
								<input type='email' name='correo' class='input1' maxlength='80' required placeholder=' ' pattern='^[a-z0-9_@.]{4,80}$'>
								<label for='correo'>Correo Electrónico</label>
							</div>
						</section>
						<section class='grid_de_1'>
							<div class='input-container'>
								<input type='text' name='asunto' class='input1' maxlength='80' required placeholder=' ' pattern='^[a-zA-Z0-9 íÍéÉáÁóÓúÚçÇ]{4,80}$'>
								<label for='asunto'>Asunto</label>
							</div>
							<div class='input-container'>
								<textarea name='mensaje' class='input_asunto_mensaje' maxlength='500' required placeholder=' ' pattern='^[a-zA-Z0-9 íÍéÉáÁóÓúÚçÇ]{4,500}$'></textarea>
								<label for='mensaje'>Mensaje</label>
							</div>
						</section>
					</div>
					<div class='div_centrar_submit'>
						<input type='submit' class='boton_submit' name='soporte' value='Enviar mensaje'>
					</div>
				</form>
			</div>
		</main>	

		<script>
			history.replaceState(null,null,location.pathname);
		</script>
	</body>
</html>";	

}else{

echo "				<li><a href='../../PHP/iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
				</ul>
			</nav>
		</header>


		<div class='contenedor_blanco_centrado_sin_inicio'>
			<div class='contenedor_texto_sin_inicio'>
			Antes de ponerte en contacto con nosotros, necesitamos <br>
			que inicie sesión o se registre.
				
				<div class='div_centrar_submit'>
					<a href='../iniciosesion/iniciosesionyregistro.php' class='boton_submit'>Haz click aquí</a>
				</div>
			</div>	 
		</div>	
	</body>
</html>";		 
}
?>
