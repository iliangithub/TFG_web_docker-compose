<?php
session_start();
?>
<?php
if (isset($_SESSION['valid_user'])) {	
echo "
<html lang='es'>
  <head>
    <title>¡Cuenta borrada exitosamente!</title>
    <meta charset='UTF-8'>
    <link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
    <link rel='stylesheet' href='borrar_cuenta.css'>
    <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
    <script src='../../JavaScript/desplegar_navegador_vertical.js'></script>
  </head>
  <body>
    <header>
        <nav>
        <button class='boton_hamburguesa_class' id='boton_hamburguesa_js' onclick='toggleMenu()'>☰</button>
        <button class='boton_cerrar_class' id='boton_x_js' onclick='closeMenu()'>✖</button>
            <ul
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
    <span class='texto'><b>¡Tu cuenta ha sido borrada exitosamente!</b><br>Borrando las Cookies y Cerrando Sesión...<p>Esperamos volver a verte pronto :(</p></span>";

/*ANULACIÓN DE LAS VARIABLES DE SESIÓN REGISTRADAS*/
unset($_SESSION['valid_user']);

/*ELIMINACIÓN DE LA SESIÓN*/
session_destroy();

echo "<script>
        function redirigir() {
            window.location.href = '../iniciosesion/iniciosesionyregistro.php';
        }
        setTimeout(redirigir, 2500);

    </script>
</body>
</html>";

}else{
echo "
<html lang='es'>
    <head>
        <title>NO PUEDES ACCEDER A ESTA PAGINA</title>
        <meta charset='UTF-8'>
        <link rel='stylesheet' href='../../CSS_comun/cuando_entras_a_la_pagina_de_forma_ilegal.css'>
        <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
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
 
<!-- http://localhost/clase/TEMA%2011%20SESIONES/PRACTICA%20REMAKE/PHP/usuario/borrar_cuenta.php -->
