<?php
session_start();

if (isset($_SESSION['valid_user'])) {
    include '../../PHP_comun/sesionname_variable.php';
}
?>

<?php
if (isset($_SESSION['valid_user'])) {
    echo "
    <html>
        <head>
            <meta charset='UTF-8'>
            <title>Usuario configuración</title>
            <link rel='stylesheet' href='estilos.css'>
            <link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
            <link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
            <link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
            <link rel='stylesheet' href='../../CSS_comun/caja_blanca_bordes.css'>
            <link rel='stylesheet' href='mi_carrito.css'>
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
                            <ul class='submenu'>
                                <li><a href='../cursos/trading.php'>Trading</a></li>
                                <li><a href='../cursos/ecommence.php'>eCommerce</a></li>
                                <li><a href='../cursos/comprar_cursos.php'>Comprar</a></li>
                            </ul>
                        </li>
                        <li><a href='../../index.php'>Menú principal</a></li>
                        <li><a href='../contacto/contacto.php'>Contacto</a></li>
                        <li><a href='#'>Usuario: " . $usuario_actual . "</a>
                            <ul class='submenu'>
                                <li><a href='../iniciosesion/logout.php'>Cerrar sesión</a></li>
                                <li><a href='configuracion.php'>Configuración</a></li>
                                <li><a href='mi_carrito.php'>Mi Carrito 🛒</a></li>
                                <li><a href='mis_cursos.php'>Mis cursos</a></li>
                                <li><a href='../usuario/ver_mi_cartera.php'>Ver mi cartera</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </header>
            <div class='contenedor_blanco_centrado'>
                <div class='contenedor_texto'>
                    <span class=titulo> Tu carro de la compra: </span><br>";

    include '../../PHP_comun/datos_conexion.php';

    $consulta_si_tienes_cursos_trading = mysqli_query($conexion, "SELECT cursos.curso , cursos.precio , cursos.id_curso FROM cursos INNER JOIN carrito_compra ON cursos.id_curso = carrito_compra.id_curso_fk INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual' AND cursos.tipo = 'trading' ORDER BY cursos.id_curso ASC");
    $consulta_si_tienes_cursos_ecommerce = mysqli_query($conexion, "SELECT cursos.curso , cursos.precio , cursos.id_curso FROM cursos INNER JOIN carrito_compra ON cursos.id_curso = carrito_compra.id_curso_fk INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual' AND cursos.tipo = 'ecommerce' ORDER BY cursos.id_curso ASC");

    if (mysqli_num_rows($consulta_si_tienes_cursos_trading) > 0 || mysqli_num_rows($consulta_si_tienes_cursos_ecommerce) > 0) {
        $suma_precios = 0;

        echo "<div class='div_cursos'>";
        if (mysqli_num_rows($consulta_si_tienes_cursos_trading) > 0) {
            echo "<p class='subtitulo_subrayado'>Cursos Trading:</p>";
        
            while ($valores = mysqli_fetch_row($consulta_si_tienes_cursos_trading)) {
                echo "<form action='mi_carrito.php' method='post'>". $valores[0] . " " .$valores[1] . "€ <input type='hidden' name='id_curso_borrar' value='".$valores[2]."'>" . "<input type='submit' class='boton_eliminar' value='Eliminar' name='eliminar_producto'></form>";
                $suma_precios += $valores[1];
            }
        }
        
        if (mysqli_num_rows($consulta_si_tienes_cursos_ecommerce) > 0) {
            echo "<p class='subtitulo_subrayado'>Cursos eCommerce:</p>";
        
            while ($valores_ecommerce = mysqli_fetch_row($consulta_si_tienes_cursos_ecommerce)) {
                echo "<form action='mi_carrito.php' method='post'>". $valores_ecommerce[0] . " " .$valores_ecommerce[1] . "€ <input type='hidden' name='id_curso_borrar' value='".$valores_ecommerce[2]."'>" . "<input type='submit' class='boton_eliminar' value='Eliminar' name='eliminar_producto'></form>";
                $suma_precios += $valores_ecommerce[1];
            }
        }

        $consulta_saldo = mysqli_prepare($conexion,"SELECT saldo FROM usuarios WHERE usuario = ?");
        mysqli_stmt_bind_param($consulta_saldo, "s", $usuario_actual);
        mysqli_stmt_execute($consulta_saldo);
        $resultado_consulta_saldo = mysqli_stmt_get_result($consulta_saldo);
        mysqli_stmt_close($consulta_saldo);
        $fila = mysqli_fetch_row($resultado_consulta_saldo);

        echo "
        <section>
            <div>
                <h3><p>TOTAL ESTIMADO: <span class='precio'>". $suma_precios . "€</span><span class='sin_descuento'> (sin descuento)</span></p>";
                
                if ($suma_precios > $fila[0]) {
                    echo "<span class='color_rojo'>TU SALDO ACTUAL ES DE: " .$fila[0] ."€ <br>Saldo insuficiente</span></h3>";
                }else{
                    echo "<span class='color_verde'>TU SALDO ACTUAL ES DE: " .$fila[0] ."€</span></h3>";
                }
        echo "   
            </div>

            <div class='div_descuentos'>
                <h1>Tus descuentos: </h1>";

        $consulta_descuentos = mysqli_prepare($conexion,"SELECT cupones.descuento FROM cupones JOIN cupones_son_canjeados ON cupones.id_cupon = cupones_son_canjeados.id_cupon_fk JOIN usuarios ON cupones_son_canjeados.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = ? AND cupones_son_canjeados.ha_sido_utilizado = ?");
        $no = "no";
        mysqli_stmt_bind_param($consulta_descuentos, "ss", $usuario_actual,$no); //he sido obligado a poner una variable $no = 'no'
        mysqli_stmt_execute($consulta_descuentos);
        $resultado_consulta_descuento= mysqli_stmt_get_result($consulta_descuentos);
        mysqli_stmt_close($consulta_descuentos);

        if (mysqli_num_rows($resultado_consulta_descuento) > 0) {
            echo "
                <form id='descuento_form' action='mi_carrito.php' method='post'>
                <h2>¿Quieres utilizar 1 ahora? ¡Selecciona tu descuento!</h2>
                    <ul>
                      <li class='no_descuento'>No quiero aplicar ningún descuento ahora <input type='radio' name='descuento_radioboton' value='0' checked></li>";

            while ($descuento_fila = mysqli_fetch_row($resultado_consulta_descuento)) {
                $precio_final_con_descuento = 0;

                $lo_que_se_descuenta = $suma_precios * ($descuento_fila[0]/100);
                
                $precio_final_con_descuento = round($suma_precios - $lo_que_se_descuenta,2); //aqui tambien lo tengo que redondear a 2 decimales
                echo "<li>". $descuento_fila[0] . "%<input type='radio' name='descuento_radioboton' value='".$descuento_fila[0]."'> → <span class='total_con_descuento'>Un total de: $precio_final_con_descuento €</span></li>";
            }
            echo    "</ul>
                </form>";
        } else {
            echo "<h3>Vaya... Parece que no tienes ningún descuento.😔</h3>";
        }

        echo   "</div>
            </section>
        </div>";

        echo "<div class='div_centrar_submit'>     
            <form id='compra_form' action='mi_carrito.php' method='post'>
                <input type='hidden' name='selected_discount' id='selected_discount' form='compra_form'>
                <input class='boton_submit' type='submit' name='comprar_deverdad' value='Comprar'>
                <input class='boton_submit' type='submit' name='vaciar_todo_carrito' value='Vaciar carrito'>
            </form>
        </div>";

        echo "<script>
                const radios = document.querySelectorAll('input[name=\"descuento_radioboton\"]');
                const selectedDiscountInput = document.getElementById('selected_discount');
                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        selectedDiscountInput.value = this.value;
                    });
                });
              </script>";
        
        mysqli_close($conexion);
        
    } else {
        echo "<p>¡Vaya!, parece que no tienes ningún curso en el carrito...</p>
        <div class='div_centrar_submit'><a class='boton_submit' href='../cursos/comprar_cursos.php'>Ir a la tienda de cursos</a></div>";
    }

    if (isset($_POST['comprar_deverdad'])) {
        include '../../PHP_comun/datos_conexion.php';
        $descuento = isset($_POST['selected_discount']) ? $_POST['selected_discount'] : 0;

        $suma_precios = 0;

        // Volver a calcular el precio total del carrito
        $consulta_si_tienes_cursos_trading = mysqli_query($conexion, "SELECT cursos.precio FROM cursos INNER JOIN carrito_compra ON cursos.id_curso = carrito_compra.id_curso_fk INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual' AND cursos.tipo = 'trading'");
        $consulta_si_tienes_cursos_ecommerce = mysqli_query($conexion, "SELECT cursos.precio FROM cursos INNER JOIN carrito_compra ON cursos.id_curso = carrito_compra.id_curso_fk INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual' AND cursos.tipo = 'ecommerce'");

        while ($valores = mysqli_fetch_row($consulta_si_tienes_cursos_trading)) {
            $suma_precios += $valores[0];
        }
        while ($valores_ecommerce = mysqli_fetch_row($consulta_si_tienes_cursos_ecommerce)) {
            $suma_precios += $valores_ecommerce[0];
        }

        if ($descuento > 0) {
            $descuento_aplicado = $suma_precios * ($descuento / 100);
            $precio_final = $suma_precios - $descuento_aplicado;
            echo "<p>Descuento aplicado: ". $descuento . "%</p>";
        } else {
            $precio_final = $suma_precios;
            echo "<p>No se ha seleccionado ningún descuento.</p>";
        }

        // Actualizar el saldo del usuario y vaciar el carrito
        $consulta_saldo = mysqli_prepare($conexion,"SELECT saldo FROM usuarios WHERE usuario = ?");
        mysqli_stmt_bind_param($consulta_saldo, "s", $usuario_actual);
        mysqli_stmt_execute($consulta_saldo);
        $resultado_consulta_saldo = mysqli_stmt_get_result($consulta_saldo);
        $fila = mysqli_fetch_row($resultado_consulta_saldo);

        if ($fila[0] >= $precio_final) {

            $consulta_cursos_carrito_compra_user = mysqli_query($conexion, "SELECT carrito_compra.id_curso_fk , carrito_compra.id_usuario_fk FROM carrito_compra INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual'");	
            
            if (mysqli_num_rows($consulta_cursos_carrito_compra_user ) > 0) {
                while ($valores_insert_compra = mysqli_fetch_row($consulta_cursos_carrito_compra_user)) {
                    $fecha_actual = date('Y-m-d');
                    $hora_actual = date('H:i:s');
                    mysqli_query($conexion, "INSERT INTO `comprados`(`id_curso_comprado_fk`, `id_usuario_comprado_fk`, `fecha`, `hora`) VALUES ('$valores_insert_compra[0]','$valores_insert_compra[1]','$fecha_actual','$hora_actual')");
                }
            }

            /*TENGO QUE hacer que el saldo sea 100% de 2 digitos:*/
            $nuevo_saldo = round($fila[0] - $precio_final, 2); // Lo tengo que redondear a 2 decimales
            $actualizar_saldo = mysqli_prepare($conexion, "UPDATE usuarios SET saldo = ? WHERE usuario = ?");
            mysqli_stmt_bind_param($actualizar_saldo, "ds", $nuevo_saldo, $usuario_actual);
            mysqli_stmt_execute($actualizar_saldo);
            mysqli_stmt_close($actualizar_saldo);


            // esto es para que los cupones ya una vez canjeados, no puedan ser utilizados: $descuento 
            $cupon_gastado= mysqli_prepare($conexion, "UPDATE cupones_son_canjeados JOIN cupones ON cupones_son_canjeados.id_cupon_fk = cupones.id_cupon JOIN usuarios ON cupones_son_canjeados.id_usuario_fk = usuarios.id_usuario SET cupones_son_canjeados.ha_sido_utilizado = ? WHERE cupones.descuento = ? AND usuarios.usuario = ?");
            $si = "si"; //lo mismo que antes, estoy obligado a hacerlo así
            mysqli_stmt_bind_param($cupon_gastado, "sss", $si ,$descuento,$usuario_actual);
            mysqli_stmt_execute($cupon_gastado);
            mysqli_stmt_close($cupon_gastado);


            //para vaciar el carrito de compra...
            $vaciar_carrito_compra= mysqli_prepare($conexion, "DELETE carrito_compra FROM carrito_compra INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = ?");
            mysqli_stmt_bind_param($vaciar_carrito_compra, "s",$usuario_actual);
            mysqli_stmt_execute($vaciar_carrito_compra);
            mysqli_stmt_close($vaciar_carrito_compra);
            include '../../PHP_comun/script_java_formulario.php';

        } else {
            include '../../PHP_comun/script_java_formulario.php';
            echo "<p>Saldo insuficiente para realizar la compra.</p>";
        }
        
        mysqli_close($conexion);
    }

    if (isset($_POST['vaciar_todo_carrito'])) {
        include '../../PHP_comun/datos_conexion.php';              
        mysqli_query($conexion, "DELETE carrito_compra FROM carrito_compra INNER JOIN usuarios ON carrito_compra.id_usuario_fk = usuarios.id_usuario WHERE usuarios.usuario = '$usuario_actual'");
        mysqli_close($conexion);
        include '../../PHP_comun/script_java_formulario.php';
    }

    if (isset($_POST['eliminar_producto'])) {
        include '../../PHP_comun/datos_conexion.php';
        
        if (isset($_POST['id_curso_borrar'])) {
            $id_curso_borrar = $_POST['id_curso_borrar'];
            $consulta_eliminar_producto = mysqli_query($conexion, "DELETE FROM carrito_compra WHERE id_curso_fk = '$id_curso_borrar' AND id_usuario_fk = (SELECT id_usuario FROM usuarios WHERE usuario = '$usuario_actual')");

            mysqli_close($conexion);
            include '../../PHP_comun/script_java_formulario.php';
        }
    }

    echo "</div>
        </div>
    </body>
</html>";

} else {
    echo "
    <html>
        <head>
            <meta charset='UTF-8'>
            <title>Usuario configuración</title>
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
