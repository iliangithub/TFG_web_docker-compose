<?php
session_start();

if (isset($_SESSION['valid_user'])) {
	echo "
<html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Redirigido a Menú Principal</title>
        <link rel='stylesheet' href='intermedio_reset_a_inicio_sesion.css'>
        <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
    </head>
    <body>
        <main>
            No puedes acceder a esta página habiendo iniciado sesión<br>
            Usted será redirigido al menú principal...
        </main>
        <!-- RECORDEMOS, QUE ESTO ES LA ÚLTIMA PANTALLA QUE VES CUANDO CONSIGUES CAMBIAR LA CONTRASEÑA -->
        <script>
            function redirigir() {
                window.location.href = '../../index.php';
            }

            setTimeout(redirigir, 3000);
        </script>

    </body>
</html>";
}else{

echo "
<html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Redirigido a Inicio Sesión</title>
        <link rel='stylesheet' href='intermedio_reset_a_inicio_sesion.css'>
        <link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
        <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
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
                    <li><a href='../iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
                </ul>
            </nav>
        </header>
        <video autoplay loop muted playsinline class='background-video-intermediorecuperada'>
				<source src='../../IMAGENES/contrasenaolvidada-bg.mp4' type='video/mp4'>
        </video>
        <main>
            Contraseña restablecida con éxito, usted será redirigido a Inicio Sesión<br>
            Por favor, que no se te vuelva a olvidar...
        </main>
        <!-- RECORDEMOS, QUE ESTO ES LA ÚLTIMA PANTALLA QUE VES CUANDO CONSIGUES CAMBIAR LA CONTRASEÑA -->
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