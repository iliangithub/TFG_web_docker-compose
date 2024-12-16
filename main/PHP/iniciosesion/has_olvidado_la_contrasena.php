<?php
session_start();

require 'vendor/autoload.php'; //para el composer

if (isset($_SESSION['valid_user'])) {
	include '../../PHP_comun/sesionname_variable.php';
}
?>


<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>¿Has olvidado la contraseña?</title>
        <link rel="stylesheet" href="has_olvidado_la_contrasena.css">
        <link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
        <link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
		<link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
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
/*ESTA PÁGINA SOLO DEBE DE APARECER EN CASO DE QUE NO TENGAS LA SESIÓN INICIADA*/
if (isset($_SESSION['valid_user'])) {
echo "              <li><a href='#'>Usuario: " . $usuario_actual . "</a>
                        <ul>
                            <li><a href='PHP/iniciosesion/logout.php'>Cerrar sesión</a></li>
                            <li><a href='PHP/usuario/configuracion.php'>Configuración</a></li>
                            <li><a href='PHP/usuario/mi_carrito.php'>Mi Carrito 🛒</a></li>
                            <li><a href='PHP/usuario/mis_cursos.php'>Mis cursos</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        
        <div class='centrar_div_entrar_formailegal'>
            <h1>
            No puedes acceder a esta página si has iniciado sesión<br>
            Usted será redirigido a su menú principal<br>
            Para acceder aquí TIENE QUE cerrar sesión
            </h1>
        </div>

        <script>
        function redirigir() {
            window.location.href = '../../index.php';
        }

        setTimeout(redirigir, 4000);
        </script>
        ";

/* todo lo de abajo SI TIENE QUE APARECER, que es básicamente en caso de NO HABER INICIADO SESIÓN*/
}else{
    echo "

            <li><a href='../iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
            </ul>
        </nav>
    </header>
    <video autoplay loop muted playsinline class='background-video-contrasenaolvidada'>
				<source src='../../IMAGENES/contrasenaolvidada-bg.mp4' type='video/mp4'>
    </video>
    <main>
        <form action='has_olvidado_la_contrasena.php' method='post'>

                <h1>¿Has Olvidado <br>La Contraseña?</h1>

                 <section><h2>Escribe Aquí abajo tu email: </h2><input type='text' name='posible_correo' pattern='^[a-z0-9._@]{4,256}$' ></section>  

            <h3>Si el email, escrito existe en nuestra Base de Datos, puedes solicitar que se te envíe por correo para restablecer la contraseña. Cuando introduzcas tu correo electrónico registrado, se te enviarán instrucciones.</h3>
            
            <div class='div_centrar_submit'>
                <input type='submit' name='olvidar_contrasena' class='boton_submit centrar_boton' id='boton_cambiar_contrasena' value='Enviar'>
            </div>
        </form>
    </main>
    <script>
        history.replaceState(null,null,location.pathname);
    </script>
    "; //este último script no quitarlo, no quiero que al refrescar la pagina me pregunte si quiero volver a mandar el formulario...
}


if (isset($_POST['olvidar_contrasena'])) {
    if (isset($_POST['posible_correo'])) {

        $posible_correo = $_POST['posible_correo'];

        if ($posible_correo != NULL) {

            include '../../PHP_comun/datos_conexion.php';

            
            $consulta_si_existe_email = mysqli_prepare($conexion, "SELECT email FROM usuarios WHERE email = ?");

            mysqli_stmt_bind_param($consulta_si_existe_email, "s", $posible_correo);
            
            mysqli_stmt_execute($consulta_si_existe_email);
            
            $resultado = mysqli_stmt_get_result($consulta_si_existe_email);

            if (mysqli_num_rows($resultado) > 0) { // Si existe el correo, pues que haga el token y le mande el email

                $token = bin2hex(random_bytes(16));
                $token_hash = hash("sha256", $token);
                $expira = date("Y-m-d H:i:s", time() + 60 * 30); // Será valido por 30 min.

                $enviar_token = mysqli_prepare($conexion, "UPDATE `usuarios` SET reset_token_hash = ?, reset_token_expira_en = ? WHERE email = ?");

                mysqli_stmt_bind_param($enviar_token, "sss", $token_hash, $expira, $posible_correo);

                if (mysqli_stmt_execute($enviar_token)) {

                   

                    $resend->emails->send([
                        'from' => 'NO_REPLY_RESET_PASSWORD<onboarding@resend.dev>',
                    'to' => [$posible_correo],
                    'subject' => 'Reseteo Contraseña RESEND, versión Docker Compose',
                    'html' => '<h2>POR FAVOR, LEA ATENTAMENTE ESTE CORREO ELECTRÓNICO Y NO RESPONDA A ESTE CORREO.</h2>
                    <p>Usted ha solicitado resetear la contraseña, para poder continuar con este procedimiento<br>
                    por favor, entra en el enlace que le proporcionamos. Por seguridad, EVITE CUALQUIER enlace<br>
                    QUE NO SEA ESTE:</p>
                    <a href=http://localhost/PHP/iniciosesion/recuperar_contrasena.php?token='.$token.'>HAZ CLICK EN ESTE ENLACE PARA CREAR UNA CONTRASEÑA NUEVA</a>
                            
                    <h2>SI TIENE ALGUNA DUDA O USTED NO HA SOLICITADO RESETEAR LA CONTRASEÑA, LE ROGAMOS QUE
                    SE COMUNIQUE INMEDIATAMENTE AL CORREO: staff-ventacursos@infocursos.es</h2>',

                    'headers' => [
                        'X-Entity-Ref-ID' => '123456789',
                    ],
                    'tags' => [
                        [
                        'name' => 'category',
                        'value' => 'confirm_email',
                        ],
                    ],
                    ]);
                    
                } else {
                    // Error al actualizar el token
                    echo "Error al actualizar el registro: " . mysqli_stmt_error($enviar_token);
                }
                
                mysqli_stmt_close($enviar_token);
            }
            mysqli_close($conexion);
            mysqli_stmt_close($consulta_si_existe_email);
        } else {
            echo "El correo está vacío";
        }

    }
}
?>

</body>
</html>
