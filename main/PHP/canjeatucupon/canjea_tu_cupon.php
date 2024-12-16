<?php
session_start();

if (isset($_SESSION['valid_user'])) {
    include '../../PHP_comun/sesionname_variable.php';
}
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Canjea tu cupón!</title>
<?php
if (isset($_SESSION['valid_user'])) {
echo "
    <link rel='stylesheet' href='canjea_tu_cupon.css'>
    <link rel='stylesheet' href='../../CSS_comun/letrita_error.css'>";
}else{
echo "
    <link rel='stylesheet' href='../../CSS_comun/cuando_no_has_iniciado_sesion.css'>
";
}
?>
    
    <link rel="icon" type="image/x-icon" href="../../IMAGENES/fav.ico">
    <link rel="stylesheet" href="../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
    <link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
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
                <li><a href="../contacto/contacto.php">Contacto</a></li>

<?php
if (isset($_SESSION['valid_user'])) {
/*========================================================== SI HAS INICIADO SESION ==============================================*/
    echo "  <li><a href='#'>Usuario: " . $usuario_actual . "</a>
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
<script>
    history.replaceState(null,null,location.pathname);
</script>
<main>
        <h1>¿Tienes un código de descuento?</h1>";

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
    /*====================================================En caso de que LO TENGAS TODO =============================================*/
        echo "<h3>Ya tienes todo listo para canjear tu cupón: </h3>
                <form method='post' action='canjea_tu_cupon.php'>
                    <section><div class='centrar_verticalmente_texto'>Cupón: </div><div><input type='text' name='cupon' class='texto_input' maxlength='15' pattern='^[a-zA-ZáÁéÉíÍóÓúÚ0-9ñÑ]{1,15}$' ></div></section>
            
                    <section class='flexbox_centrar_boton'>
                        <input type='submit' name='canjear_cupon' value='canjear cupón'>
                    </section>
                </form>";
    /*====================================================En caso de que te falte algo =============================================*/
    }elseif ($nombre == NULL || $primerapellido == NULL || $segundoapellido == NULL || $telefono == NULL || $direccion == NULL || $prefijo == NULL) {
        echo   "
                <h2>Antes de poder introducir tu cupón, necesitamos que rellenes estos datos: </h2>
                <form method='post' action='canjea_tu_cupon.php'>";
        /*===========ahora vamos individualmente en caso de que te falte algo más concreto ===========*/
        if ($nombre == NULL) {
            echo "<section><div class='centrar_verticalmente_texto'>Nombre: </div><div><input type='text' name='input_nombre' class='texto_input' maxlength='30' minlength='3' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'></div></section>";
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
            echo "<section><div class='centrar_verticalmente_texto'>Prefijo: </div><div><input type='text' name='input_prefijo' class='texto_input' placeholder='Utilice el +, por ej: +34' minlength='2' maxlength='4' pattern='[0-9+]{2,4}'></div></section>";
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
    /*======================================================================================================================================================*/

    /* y ahora, AQUI DENTRO VAN A IR LOS IF ISSET PARA RESOLVER LOS ENVIOS DE LOS FORMULARIOS, PARA AÑADIR DATOS ETC...*/

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
        location.reload();
        </script>";
mysqli_close($conexion);
}
/*===================================================================esto siiiiiiiiiiiiii es para meter los cupones ==========================================*/
if (isset($_POST['canjear_cupon'])) { // ESO SIII ES PARA LOS CUPONES

    if (isset($_POST['cupon'])) {

        $cupon = $_POST['cupon'];

        if ($cupon != NULL) {
            /* primero quiero ver, SI ESE CUPON EXISTE en la BD*/
            include '../../PHP_comun/datos_conexion.php'; //estoy obligado a abrirlo, si no me dirá Fatal error: Uncaught Error: mysqli object is already closed in C:\xampp\htdocs\TEMA 11 SESIONES\PRACTICA REMAKE\PHP\canjeatucupon\canjea_tu_cupon.php:142
            $consulta_cupones = mysqli_prepare($conexion, "SELECT id_cupon FROM `cupones` WHERE codigo_cupon = ?");
            mysqli_stmt_bind_param($consulta_cupones, "s", $cupon);
            mysqli_stmt_execute($consulta_cupones);
            $resultado = mysqli_stmt_get_result($consulta_cupones);

            if (mysqli_num_rows($resultado) > 0){
            // SI EXISTE tenemos que ver SI EL USUARIO YA LO HA CANJEADO
                $id_cupon = mysqli_fetch_row($resultado); // id_cupon[0]

                $consulta_cupones_canjeados_por_usuario = mysqli_prepare($conexion, "SELECT * FROM `cupones_son_canjeados` WHERE id_cupon_fk = ? AND id_usuario_fk = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
                mysqli_stmt_bind_param($consulta_cupones_canjeados_por_usuario, "ss", $id_cupon[0],$usuario_actual);
                mysqli_stmt_execute($consulta_cupones_canjeados_por_usuario);
                $resultado = mysqli_stmt_get_result($consulta_cupones_canjeados_por_usuario);

                if (mysqli_num_rows($resultado) > 0){
                // SI ESTÁ CANJEADO
                    echo "<p class='codigo_de_error'>El cupón introducido ya ha sido canjeado anteriormente...<p>";
                }else{
                //si no está canjeado
                    
                    //necesito saber el id del usuario...
                    $consulta_id_usuario = mysqli_prepare($conexion, "SELECT id_usuario FROM usuarios WHERE usuario = ?");
                    mysqli_stmt_bind_param($consulta_id_usuario,"s",$usuario_actual);
                    mysqli_stmt_execute($consulta_id_usuario);
                    $resultado_id = mysqli_stmt_get_result($consulta_id_usuario);
                    $id_usuario = mysqli_fetch_row($resultado_id); // id_usuario[0]

                    $insertar_cupon_usuario = mysqli_prepare($conexion, "INSERT INTO cupones_son_canjeados (id_cupon_fk, id_usuario_fk) VALUES ( ? , ? )");
                    mysqli_stmt_bind_param($insertar_cupon_usuario, "ss", $id_cupon[0],$id_usuario[0]);
                    mysqli_stmt_execute($insertar_cupon_usuario);

                    mysqli_stmt_close($insertar_cupon_usuario);
                    mysqli_stmt_close($consulta_id_usuario);

                    echo "<p class='codigo_aceptado'>¡Cupón ha sido canjeado con éxito!</p>";

                } 
                mysqli_stmt_close($consulta_cupones_canjeados_por_usuario);
            }else{
            //SI NO EXISTE
                echo "<p class='codigo_de_error'>El cupón que has introducido NO existe</p>";
            }
            mysqli_stmt_close($consulta_cupones);
            mysqli_close($conexion);

        }else{
            echo "<p class='codigo_de_error'>No has introducido ningún cupón</p>";
        }

    }
}

/* ================= lo de arriba va toda la resolución de los inputs para meter cosas en la BD ============================== */
echo"
</main>
</body>
</html>";
}else{ /* ================================================== todo esto para abajo es cuando NO HAS INICIADO SESION ==========================================*/
    echo "				<li><a href='../../PHP/iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
				</ul>
			</nav>
		</header>


		<div class='contenedor_blanco_centrado_sin_inicio'>
			<div class='contenedor_texto_sin_inicio'>
			Antes de poder canjear tu cupón, necesitamos<br>
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