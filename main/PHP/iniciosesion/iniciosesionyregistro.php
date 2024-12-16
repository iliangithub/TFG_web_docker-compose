<?php
session_start();
?>
<?php
if (isset($_POST['registrarse'])) {
    $nuevousuario = $_POST['nuevousuario'];
    $nuevacontrasena = $_POST['nuevacontrasena'];
    $nuevoemail = $_POST['nuevoemail'];

    if ($nuevousuario != NULL && $nuevacontrasena != NULL && $nuevoemail != NULL) {
        
        if (strlen($nuevousuario) >= 4 && strlen($nuevousuario) <= 30) {

            if (strlen($nuevoemail) >= 4 && strlen($nuevoemail) <= 256) {
               

                include '../../PHP_comun/datos_conexion.php';

                $consulta_si_existe_usuario = mysqli_prepare($conexion, "SELECT usuario FROM usuarios WHERE usuario= ?");

                    mysqli_stmt_bind_param($consulta_si_existe_usuario, "s", $nuevousuario);
                
                    mysqli_stmt_execute($consulta_si_existe_usuario);
                    
                    $resultado_usuario = mysqli_stmt_get_result($consulta_si_existe_usuario);

                $consulta_si_existe_email = mysqli_prepare($conexion, "SELECT email FROM usuarios WHERE email = ?");

                    mysqli_stmt_bind_param($consulta_si_existe_email, "s", $nuevoemail);
                    
                    mysqli_stmt_execute($consulta_si_existe_email);
                    
                    $resultado_email = mysqli_stmt_get_result($consulta_si_existe_email);

                if (mysqli_num_rows($resultado_usuario) == 0) {
                    if (mysqli_num_rows($resultado_email) == 0) {

                            mysqli_stmt_close($consulta_si_existe_usuario);
                            mysqli_stmt_close($consulta_si_existe_email);

                        if (strlen($nuevacontrasena) >= 4 && strlen($nuevacontrasena) <= 20) {
                            
                            $contrasena_hasheada = password_hash($nuevacontrasena, PASSWORD_BCRYPT);
                            
                            $registro = mysqli_prepare($conexion, "INSERT INTO `usuarios` (`usuario`, `contrasena`, `email`) VALUES (?,?,?)");
                            
                            mysqli_stmt_bind_param($registro, "sss", $nuevousuario , $contrasena_hasheada , $nuevoemail);
                    
                            mysqli_stmt_execute($registro);

                            $_SESSION['valid_user'] = $nuevousuario;
                            
                            echo "<p><span class='mensaje_creacion_con_exito'>Creación de usuario realizada con éxito</span></p>";

                            mysqli_stmt_close($registro);
                        
                        } else {
                            echo "<p><span class='codigos_error'>La contraseña introducida tiene que tener entre 4 y 20 caracteres</span></p>";
                        }
                    } else {
                        echo "<p><span class='codigos_error'>Parece que el email introducido ya existe en nuestra base de datos</span></p>";
                        mysqli_stmt_close($consulta_si_existe_usuario); // Esto está hecho a proposito así, pues si da error habrá que cerrar la conexión, no????
                        mysqli_stmt_close($consulta_si_existe_email); // Esto está hecho a proposito así, pues si da error habrá que cerrar la conexión, no????
                    }
                } else {
                    echo "<p><span class='codigos_error'>Parece que el usuario introducido ya existe en nuestra base de datos</span></p>";
                    mysqli_stmt_close($consulta_si_existe_usuario); // Esto está hecho a proposito así, pues si da error habrá que cerrar la conexión, no????
                    mysqli_stmt_close($consulta_si_existe_email); // Esto está hecho a proposito así, pues si da error habrá que cerrar la conexión, no????
                }
                
                mysqli_close($conexion);
            }else{
                echo "<p><span class='codigos_error'>El email introducido tiene que tener entre 4 y 256 caracteres</span></p>";
            }
        }else{
            echo "<p><span class='codigos_error'>El usuario introducido tiene que tener entre 4 y 30 caracteres</span></p>";
        }
    } else {
        echo "<p><span class='codigos_error'>Por favor, rellena todos los campos del registro</span></p>";
    }
}


// ======================================================================================================






// TODO ESTO DE LA PRIMERA PARTE DEL PHP, TIENE QUE IR PRIMERO, NOOOO PUEDE IR DESPUES
/*Warning
: Trying to access array offset on value of type null in
C:\xampp\htdocs\clase\TEMA 11 SESIONES\PRACTICA REMAKE\PHP\iniciosesion\iniciosesionyregistro.php
on line
64*/ // SOLUCIONADO, EL PROBLEMA SALIA CADA VEZ QUE DABA A INICIAR SESION SIN METER NADA
// SE HA ARREGLADO PONIENDO IFS QUE CASO DE QUE USUARIO Y CONTRASEÑA ESTÉN VACIOS


if (isset($_POST['iniciosesion'])) {
    if (isset($_POST['usuario_o_correo']) && isset($_POST['contrasena'])) {
        $usuario = $_POST['usuario_o_correo'];
        $contrasena = $_POST['contrasena'];
        
        if ($usuario != NULL && $contrasena != NULL ) {

            include '../../PHP_comun/datos_conexion.php';
            
            // Obtener la contraseña hasheada de la base de datos
            $consulta_contraseña_hasheada = mysqli_prepare($conexion, "SELECT contrasena FROM usuarios WHERE usuario = ? OR email = ?");

                mysqli_stmt_bind_param($consulta_contraseña_hasheada, "ss", $usuario , $usuario);
                    
                mysqli_stmt_execute($consulta_contraseña_hasheada);
                
                $resultado_consulta_contrasena_hasheada = mysqli_stmt_get_result($consulta_contraseña_hasheada);
            
            if ($resultado_consulta_contrasena_hasheada && mysqli_num_rows($resultado_consulta_contrasena_hasheada) > 0) {
                $fila = mysqli_fetch_row($resultado_consulta_contrasena_hasheada);
                $contrasena_hasheada_bd = $fila[0]; // El primer elemento del array es la contraseña
                
                // Verificar si la contraseña introducida coincide con la contraseña hasheada de la base de datos
                if (password_verify($contrasena, $contrasena_hasheada_bd)) {


                    mysqli_stmt_close($consulta_contraseña_hasheada);

                    /* COMO EXISTE LA POSIBILIDAD DE INICIAR SESION CON EL EMAIL, SI YO INICIO SESIÓN CON EL EMAIL
                    EL $_SESSION = VA A SER EL EMAIL Y ESO SIGNIFICA QUE EN LA BARRA DE NAVEGACIÓN, EN VEZ DE APARECER
                    EL NOMBRE DE USUARIO, APARECERÁ EL EMAIL, Y EL EMAIL ES LARGUISIMO Y ROMPE TODA LA BARRA DE NAVEGACIÓN Y QUEDA MUY MAL
                    
                    el if este lo que hace es que en caso de que haya un arroba en $usuario, significa que es un email, y en caso de ser un email pues...*/
                    if (strpos($usuario,'@') > 0) {
                        $consulta_usuario_cuyo_email= mysqli_prepare($conexion, "SELECT usuario FROM usuarios WHERE email = ?");

                        mysqli_stmt_bind_param($consulta_usuario_cuyo_email, "s", $usuario);
            
                        mysqli_stmt_execute($consulta_usuario_cuyo_email);
                        
                        $resultado_email = mysqli_stmt_get_result($consulta_usuario_cuyo_email);

                        $fila_user = mysqli_fetch_row($resultado_email);

                        $usuario = $fila_user[0];

                        mysqli_stmt_close($consulta_usuario_cuyo_email);
                    }
                    
                    $_SESSION['valid_user'] = $usuario;
                    
                    mysqli_close($conexion);
                } else {
                    echo "<span class='codigos_error'>Error, contraseña o usuario INVÁLIDO</span>";
                    mysqli_stmt_close($consulta_contraseña_hasheada);
                } 
            } else {
                echo "<span class='codigos_error'>Error, contraseña o usuario INVÁLIDO</span>";
            }
        } else {
            echo "<h1 class='codigos_error'>Error, no has rellenado los campos de inicio de sesión</h1>";           
        }
    }
}



?>

<!-- ===================================================================================================== -->

<html>
    <head>
        <title>Curso Trading Inicio Sesion</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
        <link rel="stylesheet" href="iniciosesionyregistro.css">
        <link rel="icon" type="image/x-icon" href="../../IMAGENES/fav.ico">
        <script src="../../JavaScript/desplegar_navegador_vertical.js"></script>
    </head>
    <body>
        <header>
            <nav>
            <button class='boton_hamburguesa_class' id='boton_hamburguesa_js' onclick='toggleMenu()'>☰</button>
            <button class='boton_cerrar_class' id='boton_x_js' onclick='closeMenu()'>✖</button>
                <ul>
                    <li><a href="../../PHP/canjeatucupon/canjea_tu_cupon.php">Canjea tu cupón</a></li>
                    <li><a href='#'>Cursos</a>
                        <ul class='submenu'>
                            <li><a href='../../PHP/cursos/trading.php'>Trading</a></li>
                            <li><a href='../../PHP/cursos/ecommence.php'>eCommerce</a></li>
                            <li><a href="../../PHP/cursos/comprar_cursos.php">Comprar</a></li>
                        </ul>
                    </li>
                    <li><a href='../../index.php'>Menú principal</a></li>
                    <li><a href='../../PHP/contacto/contacto.php'>Contacto</a></li>
                            
<?php
if (isset($_SESSION['valid_user'])) {
    /*LO QUE APAREZCA AQUI DENTRO, ES LO QUE VA A VER EL USUARIO UNA VEZ INICIE SESION*/
    
        echo "                  
                    <li><a href='#'>Usuario: " . $_SESSION['valid_user'] . "</a>
                        <ul>
                            <li> <a href='logout.php'>Cerrar sesión</a></li>
                            <li> <a href='../usuario/configuracion.php'>Configuración</a></li>
                            <li> <a href='../usuario/mi_carrito.php'>Mi Carrito 🛒</a></li>
                            <li> <a href='../usuario/mis_cursos.php'>Mis cursos</a></li>
                            <li> <a href='../usuario/ver_mi_cartera.php'>Ver mi cartera</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
    <video autoplay loop muted playsinline class='background-video-iniciosesion'>
				<source src='../../IMAGENES/iniciosesion-bg.mp4' type='video/mp4'>
    </video>

    <div class='mensaje_al_inciar_sesion'>Te has conectado como: " . $_SESSION['valid_user'] . "<br> En breve, serás redirigido al menú principal...</div>
    
    <script>
        function redirigir() {
            window.location.href = '../../index.php';
        }

        setTimeout(redirigir, 3000);
    </script>
    ";
} else {
    /*La intencion con este else es que a la hora de iniciar sesión y el usuario inicie sesion
    YA NO NOS MUESTRE el formulario para iniciar sesion
    
    de que me sirve iniciar sesion si me va a mostrar el formulario de abajo*/
    
    /*IMPORTANTE*/
    /*He puesto abajo la continuacion del div que corresponde al navegador de arriba en negro
    hecho a propisito para que aparezca o no aparezca el boton para iniciar sesion
    pues de que me sirve ese boton arriba si ya he iniviado sesion*/
    echo "

                    <li><a href='iniciosesionyregistro.php'>Inicio de sesión</a></li>
                 </ul>
            </nav>
        </header>
<video autoplay loop muted playsinline class='background-video-iniciosesion'>
				<source src='../../IMAGENES/iniciosesion-bg.mp4' type='video/mp4'>
</video>

<main>
    <div class='contenedor_blanco' id='container'>
        <div class='form-container sign-up'>
            <form method='post' action='iniciosesionyregistro.php'>
                <h1>Crea una cuenta</h1>
                <input type='text'      name= 'nuevousuario' id='input_error1' class='contenedor_blanco_input' placeholder='Usuario'  minlength='4' maxlength='30' pattern='^[a-z0-9_.]{4,30}$'>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error1'>El usuario no puede tener caracteres especiales 'ñ' o espacios, SOLO . y _ </div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error3'>El usuario no puede llevar MAYÚSCULAS</div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error4'>El usuario tiene que llevar de 4 a 30 caracteres</div>
                <input type='email'     name= 'nuevoemail' id='input_error_email' placeholder='Email' class='contenedor_blanco_input' minlength='4' maxlength='256' pattern='^[a-z0-9_@.]{4,256}$'>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error51'>El email no puede tener caracteres especiales 'ñ' o espacios, SOLO .  _  -</div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error52'>El email no puede llevar MAYÚSCULAS</div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error53'>El email debe tener de 4 a menos de 256 caracteres.</div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error54'>El email DEBE llevar @</div>
                
                <div class='posicion_relativa_ojo_dentro'>
                    <input type='password'  name= 'nuevacontrasena' id='input_error2' class='contenedor_blanco_input' placeholder='Contraseña' minlength='4' maxlength='20'>
                    <img src='../../IMAGENES/eye-close.png' class='ojo_iniciosesion2' id='eyeicon2'>
                </div>
                <div class='mensaje_error_input_desactivado' id='mensaje_error2'>La contraseña tiene que tener de 4 a 20 caracteres</div>
                <input type='submit' name='registrarse' class='contenedor_blanco_input' value='Registrarse'>
            </form>
        </div>
        <div class='form-container sign-in'>
            <form method='post' action='iniciosesionyregistro.php'>
                <h1>Inicia Sesión</h1>
                <span>o también puedes usar tu email </span>
                <input type='text' name='usuario_o_correo' id='usuario_inicioses' class='contenedor_blanco_input' placeholder='Usuario o Email'  minlength='4' maxlength='256' pattern='^[a-z0-9_@.]{4,256}$'>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error10'>El usuario o email tiene no puede tener caracteres especiales 'ñ' o espacios, SOLO . _ - @</div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error11'>El usuario o email tiene no puede llevar MAYÚSCULAS</div>
                 <div class='mensaje_error_input_desactivado' id='mensaje_error12'>El usuario o email tiene que llevar de 4 a 256 caracteres</div>
                  
                <div class='posicion_relativa_ojo_dentro'>
                    <input type='password' name='contrasena' id='contrasena_inicioses' class='contenedor_blanco_input' placeholder='Contraseña' minlength='4' maxlength='20'>
                    <img src='../../IMAGENES/eye-close.png' class='ojo_iniciosesion' id='eyeicon'>
                </div>

                    <div class='mensaje_error_input_desactivado' id='mensaje_error13'>La contraseña tiene que llevar de 4 a 20 caracteres</div>
                <a href='has_olvidado_la_contrasena.php'>¿Has olvidado tu contraseña?</a>
                <input type='submit' name='iniciosesion' class='contenedor_blanco_input' value='Iniciar Sesión'>
            </form>
        </div>
        <div class='toggle-container'>
            <div class='parte_azul'>
                <div class='toggle-panel toggle-left'>
                    <h1>¡Bienvenido a <br> Cursos de Trading!</h1>
                    <p>Introduce tus datos personales requeridos</p>
                    <button class='hidden' id='login'>O también, ¡Inicia Sesión!</button>
                </div>
                <div class='toggle-panel toggle-right'>
                    <h1>¿No tienes cuenta?</h1>
                    <p>Regístrate para tener acceso a todos los cursos</p>
                    <button class='hidden' id='register'>Registrarse</button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src='script.js'></script>
<script src='../../JavaScript/iniciosesionregistro_input_mensajes_error.js'></script>
<script src='../../JavaScript/solo_inicio_sesion.js'></script>
<script>history.replaceState(null,null,location.pathname);</script>";
/* EL ESCRIPT QUE VOY A METER AQUI DEBAJO ES PARA QUE FUNCIONE EL BOTON DEL OJO*/
echo " <script src='../../JavaScript/ver_contrasena.js'></script>
        <script src='../../JavaScript/ver_contrasena2.js'></script>

</body>
</html>";
}
?>
