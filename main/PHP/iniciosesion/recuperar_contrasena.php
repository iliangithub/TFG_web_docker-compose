<?php
session_start();

if (isset($_SESSION['valid_user'])) {
    echo "
    <html>
        <head>
            <meta charset='UTF-8'>
            <title>Redirigiendo...</title>
            <link rel='stylesheet' href='recuperar_contrasena.css'>
            <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
        </head>
        <body>
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
        </body>
    </html>
        ";
}else{ //en caso de que se haya entrado a la página SIN INICIAR SESIÓN que hague todo esto:
    
    $token = $_GET['token'];
    // IMPORTANTE, UNA VEZ OBTENEMOS EL TOKEN, LO TENEMOS QUE HASHEAR Y COMPARAR

    $token_hash = hash("sha256",$token);

    include '../../PHP_comun/datos_conexion.php';

    $consulta_hash = mysqli_prepare($conexion, "SELECT * FROM usuarios WHERE reset_token_hash = ?");

    mysqli_stmt_bind_param($consulta_hash, "s", $token_hash);
                
    mysqli_stmt_execute($consulta_hash);

    $resultado_consulta_hash = mysqli_stmt_get_result($consulta_hash);

    if (mysqli_num_rows($resultado_consulta_hash) > 0) { 
    /*RECORDEMOS QUE, hemos codigo del enlace el token sin hashear, lo hemos hasheado y buscamos si en la BD existe ese token hasheado y si existe 
    es porque hemos entrado con el token correcto*/

        $dia_hora_actual = date("Y-m-d H:i:s" , time()); //este es el dia y la hora actual, utilizaremos esto para comparar, si esta variable es mayor a la fecha de expiración que está almacenada en la BD pues...
        
        $fila = mysqli_fetch_row($resultado_consulta_hash); //LA FILA 11 corresponde al de la fecha y hora, a la expiración

        // aqui voy a poner la condicion de que en caso de que haya expirado
        if ($fila[11] > $dia_hora_actual ) {

            echo "
    <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Restablecer Contraseña</title>
            <link rel='stylesheet' href='recuperar_contrasena.css'>
            <link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
            <link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
            <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
            <script src='../../JavaScript/desplegar_navegador_vertical.js'></script>
            <script src='../../JavaScript/restablecer_contrasena.js'></script> "; //IMPORTANTE, ESTO SIRVE PARA LOS INPUTS DE LAS CONTRASEÑAS Y QUE SALGAN LOS BORDES ROJOS, NO TOCAR POR DIOS
echo "
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
            <video autoplay loop muted playsinline class='background-video-recuperacioncontrasena'>
				<source src='../../IMAGENES/contrasenaolvidada-bg.mp4' type='video/mp4'>
            </video>
            <main>
                <form action='recuperar_contrasena.php?token=".$token."' method='post'>
                    <input type='hidden' name='token' value='<?=htmlspecialchars(".$token.") ?>'>
                        <h1>Restablecer contraseña: </h1>

                        <section>
                            <h2>Nueva contraseña: </h2>
                            <input type='password' class='input_contrasena' id='input_contrasena1' name='contrasena1' minlength='4' maxlength='20'>
                            <p class='mensaje_error_por_defecto' id='mensaje_error_poco_caracteres'>La contraseña tiene que ser de 4 a 20 caracteres.</p>
                            <h2>Repite la contraseña: </h2>
                            
                            <input type='password' class='input_contrasena' id='input_contrasena2' name='contrasena2' minlength='4' maxlength='20'>
                            <p class='mensaje_error_por_defecto' id='mensaje_error_iguales'>Ambas contraseñas deben ser iguales.</p>  
                        </section>  

                    <h3>Por favor, procura que no se te olvide esta vez.</h3>
                    
                    <div class='div_centrar_submit'>
                        <input type='submit' name='resetear_contrasena' class='boton_submit centrar_boton' id='boton_cambiar_contrasena' value='Enviar'>
                    </div>
                </form>       
    ";

            if (isset($_POST['resetear_contrasena'])) {

                if (isset($_POST['contrasena1'] ) && isset($_POST['contrasena2'] )) {

                    $contrasena1 = $_POST['contrasena1'];
                    $contrasena2 = $_POST['contrasena2'];

                    if ($contrasena1 != NULL && $contrasena2 != NULL ) {
                        if ($contrasena1 == $contrasena2) {
                            echo "<p>Las contraseñas son iguales.</p>";

                            // si son iguales, ahora voy a hashearlas y meterlas en la BD.

                            include '../../PHP_comun/datos_conexion.php';

                            $contrasena_hasheada = password_hash($contrasena1, PASSWORD_BCRYPT);

                            $update_contrasena = mysqli_prepare($conexion, "UPDATE usuarios SET contrasena= ? WHERE reset_token_hash = ?");

                            mysqli_stmt_bind_param($update_contrasena, "ss",$contrasena_hasheada,$token_hash);
                                        
                            mysqli_stmt_execute($update_contrasena);

                            mysqli_stmt_close($update_contrasena);
                            
                            // como todo está bien tengo que redirigir a "intermedio_reset_a_inicio_sesion.php"
                            echo "<script>
                                    history.replaceState(null,null,location.pathname)
                                    window.location.href = 'intermedio_reset_a_inicio_sesion.php';
                                </script>";
                        }else{
                            echo "<p>Por favor, las dos contraseñas tienen que ser iguales.</p>";
                        }
                    }elseif ($contrasena1 != NULL || $contrasena2 != NULL ) {
                        echo "<p>Por favor, tienes que rellenar los dos campos.</p>";
                    }elseif ($contrasena1 == NULL && $contrasena2 == NULL ) {
                        echo "<p>No tienes ningún campo rellenado.</p>";
                    }               
                
                }
            }
    echo "</main>
        </body>
    </html>  ";
        }else{
            echo "
    <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Restablecer Contraseña</title>
            <link rel='stylesheet' href='recuperar_contrasena.css'>
            <link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
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
            <main class='flexbox_token_expirado'>
                <h1>Token y enlace han expirado<br>
                Usted será reenviado a la página para recuperar la contraseña<br>
                Así recibirá un nuevo correo con un nuevo token y enlace...</h1>
            </main>
            <script>
            function redirigir() {
                window.location.href = 'has_olvidado_la_contrasena.php';
            }

            setTimeout(redirigir, 4000);
            </script>
        </body>
    </html>";
        }
    }else{
        echo "
    <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Restablecer Contraseña</title>
            <link rel='stylesheet' href='recuperar_contrasena.css'>
            <link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
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
        
            <main class='flexbox_token_expirado'>
                <h1>Token NO encontrado <br>
                USTED ESTÁ ENTRANDO DE FORMA ILEGAL SIN UTILIZAR EL ENLACE<br>
                que deberíamos haber proporcionado. <br><br>Será redirigido a la página de recuperación de contraseña.</h1>
            </main>
            <script>
            function redirigir() {
                window.location.href = 'has_olvidado_la_contrasena.php';
            }

            setTimeout(redirigir, 5000);
            </script>
        </body>
    </html>";
    }
    mysqli_stmt_close($consulta_hash);

}//este cierre de corchete es del isset($_SESSION)
?>