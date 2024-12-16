<?php
session_start();

include '../../PHP_comun/datos_conexion.php';

if (isset($_SESSION['valid_user'])) {

	include '../../PHP_comun/sesionname_variable.php';

    // Procesar la solicitud de añadir fondos
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cantidad = 0;
        if (isset($_POST['cantidad5'])) {
            $cantidad = $_POST['cantidad5'];
        } elseif (isset($_POST['cantidad10'])) {
            $cantidad = $_POST['cantidad10'];
        } elseif (isset($_POST['cantidad25'])) {
            $cantidad = $_POST['cantidad25'];
        } elseif (isset($_POST['cantidad50'])) {
            $cantidad = $_POST['cantidad50'];
        } elseif (isset($_POST['cantidad100'])) {
            $cantidad = $_POST['cantidad100'];
        }

        if ($cantidad > 0) {

            $update_cartera = mysqli_prepare($conexion, "UPDATE usuarios SET saldo = saldo + ? WHERE usuario = ?");
            mysqli_stmt_bind_param($update_cartera, "is", $cantidad, $usuario_actual);
            if (mysqli_stmt_execute($update_cartera)) {
                // para refrescar la página
                echo "<script>window.location.href = 'ver_mi_cartera.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error al añadir fondos');</script>";
            }
            mysqli_stmt_close($update_cartera);
        }
    }
}//TODO ESTO NO MOVERLO DE SITIO
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
		<title>Ver mi cartera</title>
		<link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
		<link rel='stylesheet' href='../../CSS_comun/caja_blanca_bordes.css'>
		<link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
		<link rel='stylesheet' href='ver_mi_cartera.css'>
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
					<li><a href='#'>Usuario: " . $_SESSION['valid_user'] . "</a>
						<ul>
							<li> <a href='../iniciosesion/logout.php'>Cerrar sesión</a></li>
							<li> <a href='configuracion.php'>Configuración</a></li>
							<li> <a href='mi_carrito.php'>Mi Carrito 🛒</a></li>
							<li> <a href='mis_cursos.php'>Mis cursos</a></li>
							<li> <a href='#'>Ver mi cartera</a></li>	
						</ul>
					</li>
				</ul>
			</nav>
		</header>
		<div class='contenedor_blanco_centrado'>
			<div class='contenedor_texto'>";


include '../../PHP_comun/datos_conexion.php';
include '../../PHP_comun/sesionname_variable.php';

echo "<h1>AÑADIR FONDOS A LA CARTERA DE " .$usuario_actual."</h1>
<main>
	<div class='grid_denuevo'>
		<form action='ver_mi_cartera.php' method='post'>
			<div class='contenedor_fondos'>
				<div>
				Añadir 5,--€
				<h5>Nivel mínimo de fondos</h5>
				</div>
				<div class='display_flex_derecha'>
					<div class='mini_contenedor_negro'>
						5,--€<button name='cantidad5' value='5'>Añadir fondos</button>
					</div>
				</div>
			</div>

			<div class='contenedor_fondos'>
				<div>
				Añadir 10,--€
				</div>
				<div class='display_flex_derecha'>
					<div class='mini_contenedor_negro'>
						10,--€<button name='cantidad10' value='10'>Añadir fondos</button>
					</div>
				</div>
			</div>

			<div class='contenedor_fondos'>
				<div>
				Añadir 25,--€
				</div>
				<div class='display_flex_derecha'>
					<div class='mini_contenedor_negro'>
						25,--€<button name='cantidad25' value='25'>Añadir fondos</button>
					</div>
				</div>
			</div>

			<div class='contenedor_fondos'>
				<div>
				Añadir 50,--€
				</div>
				<div class='display_flex_derecha'>
					<div class='mini_contenedor_negro'>
						50,--€<button name='cantidad50' value='50'>Añadir fondos</button>
					</div>
				</div>
			</div>

			<div class='contenedor_fondos'>
				<div>
				Añadir 100,--€
				</div>
				<div class='display_flex_derecha'>
					<div class='mini_contenedor_negro'>
						100,--€<button name='cantidad100' value='100'>Añadir fondos</button>
					</div>
				</div>
			</div>
		</form>
		<section>
			Saldo actual de la Cartera: ";
$consulta_saldo = mysqli_prepare($conexion,"SELECT saldo FROM usuarios WHERE usuario = ?");
mysqli_stmt_bind_param($consulta_saldo, "s", $usuario_actual);
mysqli_stmt_execute($consulta_saldo);
$resultado_consulta_saldo = mysqli_stmt_get_result($consulta_saldo);
mysqli_stmt_close($consulta_saldo);
$fila = mysqli_fetch_row($resultado_consulta_saldo);

echo  "<p>". $fila[0] . " €</p>";

echo	"</section>
	</div>
</main>
";
			
echo		"</div>
		</div>
";
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
