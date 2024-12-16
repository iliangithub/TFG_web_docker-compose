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
		<link rel='stylesheet' href='configuracion.css'>
		<link rel='icon' type='image/x-icon' href='../../IMAGENES/fav.ico'>
		<link rel='stylesheet' href='../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css'>
		<link rel='stylesheet' href='../../CSS_comun/solo_botones_submit.css'>
		<link rel='stylesheet' href='../../CSS_comun/caja_blanca_bordes.css'>
		<link rel='stylesheet' href='../../CSS_comun/letrita_error.css'>
		<link rel='stylesheet' href='../../CSS_comun/cartelitos_warning_correcto_error.css'>
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
							<li> <a href='../iniciosesion/logout.php'>Cerrar sesión</a></li>
							<li> <a href='configuracion.php'>Configuración</a></li>
							<li> <a href='mi_carrito.php'>Mi Carrito</a></li>
							<li> <a href='mis_cursos.php'>Mis Cursos</a></li>
							<li> <a href='../usuario/ver_mi_cartera.php'>Ver mi cartera</a></li>							
						</ul>
					</li>	
				</ul>  
			</nav>
		</header>
		<div class='contenedor_blanco_centrado'>
			<div class='contenedor_texto'>

<div class='titulo_bienvenido'><p>Ajustes del usuario:</p> </div>
<p><span class='titulo_pequeno_subrayado'>Mis datos personales: </span><br></p>";

include '../../PHP_comun/datos_conexion.php';

$consulta_datos_personales = mysqli_prepare($conexion, "SELECT email, nombre, primerapellido, segundoapellido, telefono, direccion FROM usuarios WHERE usuario = ?");
mysqli_stmt_bind_param($consulta_datos_personales, "s", $usuario_actual);
mysqli_stmt_execute($consulta_datos_personales);

mysqli_stmt_bind_result($consulta_datos_personales, $email, $nombre, $primerapellido, $segundoapellido, $telefono, $direccion);

mysqli_stmt_fetch($consulta_datos_personales);

mysqli_stmt_close($consulta_datos_personales);

mysqli_close($conexion);

echo "
<div class='grid_datos_personales'>
    <div>Correo Electrónico: </div><div>" . $email . "</div>
    <div>Nombre: </div><div>" . $nombre . "</div>
    <div>Primer Apellido: </div><div>" . $primerapellido . "</div>
    <div>Segundo Apellido: </div><div>" . $segundoapellido . "</div>
    <div>Teléfono: </div><div>" . $telefono . "</div>
    <div>Dirección de Domicilio: </div><div>" . $direccion . "</div>
</div>
<p><span class='titulo_pequeno_subrayado'>Cambiar de contraseña: </span><br></p>


<form action='configuracion.php' method='post'> 
    <div class='contenedor_solo_para_hacer_grid'>
        <div class='columna'>
            Contraseña actual: 
            <input type='password' class='input_formulario' name='contrasena_antigua' id='contrasena_antigua' minlength='4' maxlength='20'>
            <p class='formulario_mensaje_error_del_input_desactivado'>Error, contraseña actual errónea</p>
            
        </div>

        <div class='columna'>
            Contraseña nueva:
            <input type='password' class='input_formulario' name='contrasena_nueva1' id='contrasena_nueva1' minlength='4' maxlength='20'>
            <p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error2'>La contraseña tiene que ser de 4 a 20 caracteres.</p> 
        </div>

        <div class='columna'>
            Repetir la contraseña nueva:
            <input type='password' class='input_formulario' name='contrasena_nueva2' id='contrasena_nueva2' minlength='4' maxlength='20'>
            <p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error3' >Ambas contraseñas deben ser iguales.</p>          
        </div>

    </div>
    <div class='div_centrar_submit'>
        <br><input type='submit' name='cambiarcontrasena' class='boton_submit centrar_boton' id='boton_cambiar_contrasena' value='Cambiar Contraseña'>
    </div>
</form>
		<script src='../../JavaScript/cartelitos_warning_correcto_error.js'></script>
		<script src='../../JavaScript/configuracion_contrasenas.js'></script>";

/* aqui voy a poner la resolucion del formulario de cambiar la contraseña*/
/*

		SUPER IMPORTANTE, ES IMPRESINDIBLE
		PONER QUE LAS CONTRASEÑAS SEAN IGUALES AQUI EN EL PHP

		AUNQUE LITERALMENTE NO NOS SIRVA PARA NADA
		ESO SE HACE PORQUE EL JAVASCRIPT LO HEMOS USADO
		SOLO PARA QUE VISUALMENTE SEPAS SI LAS CONTRASEÑAS SEAN IGUALES

		PERO NADIE IMPIDE QUE EL USUARIO MANDE A CAMBIAR LAS CONTRASEÑAS
		A PESAR DE QUE SE LO MARQUE EL JAVASCRIPT COMO QUE NO SON IGUALES
		Y ES UN MÉTODO DE SEGURIDAD DEMÁS.*/
		if (isset($_POST['cambiarcontrasena'])) {
			if (isset($_POST['contrasena_nueva1']) && isset($_POST['contrasena_nueva2']) && isset($_POST['contrasena_antigua'])) {
				$contrasena_antigua = $_POST['contrasena_antigua'];
				$contrasena1 = $_POST['contrasena_nueva1'];
				$contrasena2 = $_POST['contrasena_nueva2'];
		
				if (!empty($contrasena1) && !empty($contrasena2) && !empty($contrasena_antigua)) {
					if ($contrasena1 === $contrasena2) {
						if (strlen($contrasena1) >= 4 && strlen($contrasena1) <= 20) {
		
							include '../../PHP_comun/datos_conexion.php';
							include '../../PHP_comun/sesionname_variable.php';
		
							// Consulta para obtener la contraseña almacenada en la base de datos
							$consulta_contraseña_hasheada = mysqli_prepare($conexion, "SELECT contrasena FROM usuarios WHERE usuario = ?");
							if ($consulta_contraseña_hasheada) {
								mysqli_stmt_bind_param($consulta_contraseña_hasheada, "s", $usuario_actual);
								mysqli_stmt_execute($consulta_contraseña_hasheada);
								$resultado_consulta_contr_hash = mysqli_stmt_get_result($consulta_contraseña_hasheada);
		
								if ($resultado_consulta_contr_hash && mysqli_num_rows($resultado_consulta_contr_hash) > 0) {
									$fila = mysqli_fetch_row($resultado_consulta_contr_hash);
									$contrasena_hasheada_bd = $fila[0]; // El primer elemento del array es la contraseña actual de la BD
		
									if (password_verify($contrasena_antigua, $contrasena_hasheada_bd)) {
										// Verificar la contraseña antigua ingresada con la almacenada en la base de datos
										$contrasena_hasheada = password_hash($contrasena1, PASSWORD_BCRYPT); // Hashear la nueva contraseña
		
										// Actualizar la contraseña en la base de datos
										$resultado_update = mysqli_prepare($conexion, "UPDATE usuarios SET contrasena = ? WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
										if ($resultado_update) {
											mysqli_stmt_bind_param($resultado_update, "ss", $contrasena_hasheada, $usuario_actual);
											mysqli_stmt_execute($resultado_update);
		
											if (mysqli_stmt_affected_rows($resultado_update) > 0) {
												echo "<div class='codigo_aceptado'>¡Operación realizada con éxito!</div>";
											} else {
												echo "<div class='codigo_de_error'>Error al actualizar la contraseña</div>";
											}
		
											mysqli_stmt_close($resultado_update); // Cierre de la sentencia preparada para actualización
										} else {
											echo "<div class='codigo_de_error'>Error en la preparación de la consulta de actualización</div>";
										}
									} else {
										echo "<div class='codigo_de_error'>LA CONTRASEÑA ANTIGUA NO COINCIDE</div>";
									}
								} else {
									echo "<div class='codigo_de_error'>Error al obtener la contraseña almacenada</div>";
								}
		
								mysqli_stmt_close($consulta_contraseña_hasheada); // Cierre de la sentencia preparada para la consulta de la contraseña
							} else {
								echo "<div class='codigo_de_error'>Error en la preparación de la consulta de obtención</div>";
							}
		
							mysqli_close($conexion); // Cierre de la conexión a la base de datos
						} else {
							echo "<div class='codigo_de_error'>Las contraseñas tienen que ser más de 4 caracteres y menos de 20</div>";
						}
					} else {
						echo "<div class='codigo_de_error'>Las contraseñas tienen que ser iguales</div>";
					}
				} else {
					echo "<div class='codigo_de_error'>Debes de rellenar los tres campos</div>";
				}
			} else {
				echo "<div class='codigo_de_error'>No has introducido nada</div>";
			}
		}
				

		
echo   "<form action='configuracion.php' method='post'>
			<div class='contenedor_telefono_direccion'>
				<div>
					<p class='titulo_pequeno_subrayado'>Cambiar Prefijo y Teléfono:</p>
					<div class='grid_de_nuevo'>
					<select name='prefijo_paises_telefono' class='select_css'>
						<option value=''> </option>
						<option value='+49'>🇩🇪 Alemania: +49</option>
						<option value='+355'>🇦🇱 Albania: +355</option>
						<option value='+966'>🇸🇦 Arabia Saudita: +966</option>
						<option value='+54'>🇦🇷 Argentina: +54</option>
						<option value='+374'>🇦🇲 Armenia: +374</option>
						<option value='+61'>🇦🇺 Australia: +61</option>
						<option value='+43'>🇦🇹 Austria: +43</option>
						<option value='+994'>🇦🇿 Azerbaiyán: +994</option>
						<option value='+973'>🇧🇭 Bahréin: +973</option>
						<option value='+880'>🇧🇩 Bangladés: +880</option>
						<option value='+32'>🇧🇪 Bélgica: +32</option>
						<option value='+387'>🇧🇦 Bosnia y Herzegovina: +387</option>
						<option value='+55'>🇧🇷 Brasil: +55</option>
						<option value='+359'>🇧🇬 Bulgaria: +359</option>
						<option value='+975'>🇧🇹 Bután: +975</option>
						<option value='+1'>🇨🇦 Canadá: +1</option>
						<option value='+56'>🇨🇱 Chile: +56</option>
						<option value='+86'>🇨🇳 China: +86</option>
						<option value='+57'>🇨🇴 Colombia: +57</option>
						<option value='+82'>🇰🇷 Corea del Sur: +82</option>
						<option value='+506'>🇨🇷 Costa Rica: +506</option>
						<option value='+385'>🇭🇷 Croacia: +385</option>
						<option value='+45'>🇩🇰 Dinamarca: +45</option>
						<option value='+593'>🇪🇨 Ecuador: +593</option>
						<option value='+20'>🇪🇬 Egipto: +20</option>
						<option value='+971'>🇦🇪 Emiratos Árabes Unidos: +971</option>
						<option value='+421'>🇸🇰 Eslovaquia: +421</option>
						<option value='+386'>🇸🇮 Eslovenia: +386</option>
						<option value='+34'>🇪🇸 España: +34</option>
						<option value='+1'>🇺🇸 Estados Unidos: +1</option>
						<option value='+63'>🇵🇭 Filipinas: +63</option>
						<option value='+358'>🇫🇮 Finlandia: +358</option>
						<option value='+33'>🇫🇷 Francia: +33</option>
						<option value='+995'>🇬🇪 Georgia: +995</option>
						<option value='+30'>🇬🇷 Grecia: +30</option>
						<option value='+852'>🇭🇰 Hong Kong: +852</option>
						<option value='+36'>🇭🇺 Hungría: +36</option>
						<option value='+91'>🇮🇳 India: +91</option>
						<option value='+62'>🇮🇩 Indonesia: +62</option>
						<option value='+98'>🇮🇷 Irán: +98</option>
						<option value='+964'>🇮🇶 Iraq: +964</option>
						<option value='+353'>🇮🇪 Irlanda: +353</option>
						<option value='+972'>🇮🇱 Israel: +972</option>
						<option value='+39'>🇮🇹 Italia: +39</option>
						<option value='+81'>🇯🇵 Japón: +81</option>
						<option value='+962'>🇯🇴 Jordania: +962</option>
						<option value='+7'>🇰🇿 Kazajistán: +7</option>
						<option value='+996'>🇰🇬 Kirguistán: +996</option>
						<option value='+965'>🇰🇼 Kuwait: +965</option>
						<option value='+961'>🇱🇧 Líbano: +961</option>
						<option value='+60'>🇲🇾 Malasia: +60</option>
						<option value='+960'>🇲🇻 Maldivas: +960</option>
						<option value='+389'>🇲🇰 Macedonia del Norte: +389</option>
						<option value='+52'>🇲🇽 México: +52</option>
						<option value='+976'>🇲🇳 Mongolia: +976</option>
						<option value='+382'>🇲🇪 Montenegro: +382</option>
						<option value='+977'>🇳🇵 Nepal: +977</option>
						<option value='+64'>🇳🇿 Nueva Zelanda: +64</option>
						<option value='+47'>🇳🇴 Noruega: +47</option>
						<option value='+968'>🇴🇲 Omán: +968</option>
						<option value='+31'>🇳🇱 Países Bajos: +31</option>
						<option value='+92'>🇵🇰 Pakistán: +92</option>
						<option value='+507'>🇵🇦 Panamá: +507</option>
						<option value='+51'>🇵🇪 Perú: +51</option>
						<option value='+48'>🇵🇱 Polonia: +48</option>
						<option value='+351'>🇵🇹 Portugal: +351</option>
						<option value='+974'>🇶🇦 Qatar: +974</option>
						<option value='+44'>🇬🇧 Reino Unido: +44</option>
						<option value='+420'>🇨🇿 República Checa: +420</option>
						<option value='+40'>🇷🇴 Rumania: +40</option>
						<option value='+7'>🇷🇺 Rusia: +7</option>
						<option value='+381'>🇷🇸 Serbia: +381</option>
						<option value='+65'>🇸🇬 Singapur: +65</option>
						<option value='+94'>🇱🇰 Sri Lanka: +94</option>
						<option value='+27'>🇿🇦 Sudáfrica: +27</option>
						<option value='+46'>🇸🇪 Suecia: +46</option>
						<option value='+41'>🇨🇭 Suiza: +41</option>
						<option value='+963'>🇸🇾 Siria: +963</option>
						<option value='+66'>🇹🇭 Tailandia: +66</option>
						<option value='+886'>🇹🇼 Taiwán: +886</option>
						<option value='+992'>🇹🇯 Tayikistán: +992</option>
						<option value='+90'>🇹🇷 Turquía: +90</option>
						<option value='+993'>🇹🇲 Turkmenistán: +993</option>
						<option value='+380'>🇺🇦 Ucrania: +380</option>
						<option value='+598'>🇺🇾 Uruguay: +598</option>
						<option value='+998'>🇺🇿 Uzbekistán: +998</option>
						<option value='+58'>🇻🇪 Venezuela: +58</option>
						<option value='+84'>🇻🇳 Vietnam: +84</option>
						<option value='+967'>🇾🇪 Yemen: +967</option>
					</select>
					<input type='tel' name='telefono' class='input_formulario' id='telefono_id' placeholder='Aquí va el teléfono' minlength='7' maxlength='14' pattern='[0-9]{7,14}'>
					</div>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error4'>El teléfono debe tener entre 7 a 14 dígitos</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error9'>El teléfono NO puede contener letras</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error10'>El teléfono NO puede llevar caracteres especiales</p>
				</div>
				<div>
					<p class='titulo_pequeno_subrayado'>Cambiar Dirección de Domicilio:</p>
					<input type='text' name='direccion' class='input_formulario' id='direccion_id' placeholder='Aquí va tu dirección de residencia' maxlength='50' pattern='^[a-zA-Z0-9 íÍéÉáÁóÓúÚçÇ]{4,50}$'>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error8'>No puedes utilizar caracteres especiales</p>
				</div>
			</div>

			<p><span class='titulo_pequeno_subrayado'>Cambiar Nombre o Apellidos:</span></p>

			<div class='contenedor_nombre_apellidos'>
				<div class='columna'>
					<input type='text' name='nombre' id='nombre_id' placeholder='Aquí va el nombre' maxlength='30' minlength='3' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error5'>El nombre no puede tener caracteres especiales.</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error13'>El nombre no puede tener números.</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error55'>El nombre tiene que tener entre 3 y 30 caracteres.</p>
				</div>
				<div class='columna'>
					<input type='text' name='primerapellido' id='primerapellido_id' placeholder='Aquí va el primer apellido' minlength='3' maxlength='30' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error6'>El Primer Apellido no puede tener caracteres especiales.</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error14'>El Primer Apellido no puede tener números.</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error56'>El Primer Apellido tiene que tener entre 3 y 30 caracteres.</p>
				</div>
				<div class='columna'>
					<input type='text' name='segundoapellido' id='segundoapellido_id' placeholder='Aquí va el segundo apellido' minlength='3' maxlength='30' pattern='^[a-zA-Z íÍéÉáÁóÓúÚçÇñÑ]{3,30}$'>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error7'>El Segundo Apellido no puede tener caracteres especiales.</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error15'>El Segundo Apellido no puede tener números.</p>
					<p class='formulario_mensaje_error_del_input_desactivado' id='mensaje_error57'>El Segundo Apellido tiene que tener entre 3 y 30 caracteres.</p>
				</div>       
			</div>

			<div class='div_centrar_submit'>
			<input type='submit' name='cambiar' value='CAMBIAR DATOS' class='boton_submit'>
			</div>
		</form>
		<script src='../../JavaScript/configuracion_telefono_direccion.js'></script>
		<script src='../../JavaScript/configuracion_nombre_apellidos.js'></script> ";

if (isset($_POST['cambiar'])) {
	include '../../PHP_comun/datos_conexion.php';
	include '../../PHP_comun/sesionname_variable.php';

	if (isset($_POST['telefono']) && isset($_POST['prefijo_paises_telefono'])) {
		$telefono = $_POST['telefono'];
		$prefijo = $_POST['prefijo_paises_telefono'];
		if ($telefono != NULL && $prefijo != NULL) {
			if (strlen($telefono) >= 7 && strlen($telefono) <= 14) {

				$update_telefono_prefijo = mysqli_prepare($conexion, "UPDATE usuarios SET telefono = ?, prefijo_telefono = ? WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
				 mysqli_stmt_bind_param($update_telefono_prefijo, "sss",$telefono,$prefijo,$usuario_actual);
				 mysqli_stmt_execute($update_telefono_prefijo);
				 mysqli_stmt_close($update_telefono_prefijo);

			}else{
				echo "<h1>el telefono tiene que ser entre 7 a 9 dígitos</h1>";
			}
			
		}elseif ($telefono != NULL || $prefijo != NULL) {
			echo  "<div class='codigo_de_error'>Tienes que introducir el teléfono y seleccionar el prefijo</div>";

		}elseif ($telefono == NULL && $prefijo == NULL) {
			echo "";
		}
	}
	if (isset($_POST['direccion'])) {
		$direccion = $_POST['direccion'];
		if ($direccion != NULL ) {
			
			$update_direccion = mysqli_prepare($conexion, "UPDATE usuarios SET direccion = ? WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
			mysqli_stmt_bind_param($update_direccion, "ss",$direccion,$usuario_actual);
			mysqli_stmt_execute($update_direccion);
			mysqli_stmt_close($update_direccion);
		}
	}
	if (isset($_POST['nombre'])) {
		$nombre = $_POST['nombre'];
		if ($nombre != NULL ) {

			$update_nombre = mysqli_prepare($conexion, "UPDATE usuarios SET nombre = ? WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
			mysqli_stmt_bind_param($update_nombre, "ss",$nombre,$usuario_actual);
			mysqli_stmt_execute($update_nombre);
			mysqli_stmt_close($update_nombre);
		}
	}
	if (isset($_POST['primerapellido'])) {
		$primerapellido = $_POST['primerapellido'];
		if ($primerapellido != NULL ) {
			$update_primerapellido= mysqli_prepare($conexion, "UPDATE usuarios SET primerapellido = ? WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
			mysqli_stmt_bind_param($update_primerapellido, "ss",$primerapellido,$usuario_actual);
			mysqli_stmt_execute($update_primerapellido);
			mysqli_stmt_close($update_primerapellido);
		}
	}
	if (isset($_POST['segundoapellido'])) {
		$segundoapellido = $_POST['segundoapellido'];
		if ($segundoapellido != NULL ) {
			$update_segundoapellido = mysqli_prepare($conexion, "UPDATE usuarios SET segundoapellido = ? WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
			mysqli_stmt_bind_param($update_segundoapellido, "ss",$segundoapellido,$usuario_actual);
			mysqli_stmt_execute($update_segundoapellido);
			mysqli_stmt_close($update_segundoapellido);
		}
	}
	mysqli_close($conexion);
	include '../../PHP_comun/script_java_formulario.php'; // esto no lo quites por favor, sirve para refrescar y si, es necesario refrescar
}

echo			"
			<form class='seccion_borrar_cuenta' action='configuracion.php' method='post'>
			<p><span class='titulo_pequeno_subrayado'>Borrar cuenta:</span></p>
				
					Contraseña Actual: <input type='password' class='input_borrar_contrasena' name='contrasena_antigua_borrar' minlength='4' maxlength='20'>
				
				<div class='div_borrar_cuenta_grid2'><div>Estoy totalmente seguro de que deseo eliminar PERMANENTEMENTE mi cuenta SOY CONSCIENTE de que el dinero no será reembolsado</div><div><input type='checkbox' name='confirmar_borrado'></div></div>
					<div class='div_centrar_submit'>
					<input type='submit' name='borrar' value='eliminar cuenta' class='boton_submit'>
					</div>
			</form>";	
				
			
		

if (isset($_POST['borrar'])) {
	if (isset($_POST['contrasena_antigua_borrar'])) {
		$contrasena_antigua2 = $_POST['contrasena_antigua_borrar'];
		if ($contrasena_antigua2 != NULL) {
			include '../../PHP_comun/datos_conexion.php';
			include '../../PHP_comun/sesionname_variable.php';

			$consulta_contraseña_hasheada = mysqli_prepare($conexion, "SELECT contrasena FROM usuarios WHERE usuario = ?");
			if ($consulta_contraseña_hasheada) {
				mysqli_stmt_bind_param($consulta_contraseña_hasheada, "s", $usuario_actual);
				mysqli_stmt_execute($consulta_contraseña_hasheada);
				mysqli_stmt_bind_result($consulta_contraseña_hasheada, $contrasena_hasheada_bd);
				mysqli_stmt_fetch($consulta_contraseña_hasheada);

				if (password_verify($contrasena_antigua2, $contrasena_hasheada_bd)) {
					if (isset($_POST['confirmar_borrado'])) {
						mysqli_stmt_close($consulta_contraseña_hasheada);
						$delete_cupones = mysqli_prepare($conexion, "DELETE FROM cupones_son_canjeados WHERE id_usuario_fk = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
						$delete_comprados = mysqli_prepare($conexion, "DELETE FROM comprados WHERE id_usuario_comprado_fk = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
						$delete_carrito = mysqli_prepare($conexion, "DELETE FROM carrito_compra WHERE id_usuario_fk = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");
						$delete_usuarios = mysqli_prepare($conexion, "DELETE FROM usuarios WHERE id_usuario = (SELECT id_usuario FROM usuarios WHERE usuario = ?)");

						if ($delete_cupones && $delete_comprados && $delete_carrito && $delete_usuarios) {
							mysqli_stmt_bind_param($delete_cupones, "s", $usuario_actual);
							mysqli_stmt_bind_param($delete_comprados, "s", $usuario_actual);
							mysqli_stmt_bind_param($delete_carrito, "s", $usuario_actual);
							mysqli_stmt_bind_param($delete_usuarios, "s", $usuario_actual);

							mysqli_stmt_execute($delete_cupones);
							mysqli_stmt_execute($delete_comprados);
							mysqli_stmt_execute($delete_carrito);
							mysqli_stmt_execute($delete_usuarios);

							mysqli_stmt_close($delete_cupones);
							mysqli_stmt_close($delete_comprados);
							mysqli_stmt_close($delete_carrito);
							mysqli_stmt_close($delete_usuarios);

							mysqli_close($conexion);

							echo "<script>
							function redirigir() {
							window.location.href = 'borrar_cuenta.php';
								}
							redirigir();
							</script>";

						} else {
							echo "<h1>Error en la preparación de una consulta de eliminación</h1>";
						}
					} else {
						echo "<div class='codigo_de_error'>Debes confirmar el borrado de la cuenta</div>";
					}
				} else {
					echo "<div class='codigo_de_error'>Contraseña incorrecta</div>";
				}
			}
		}
	}
}
echo "</div>
</div>
	</body>
</html>"
;
}else{
echo "
<html>
	<head>
		<meta charset='UTF-8'>
		<title>Usuario configuración</title>
		<link rel='stylesheet' href='../../CSS_comun/cuando_entras_a_la_pagina_de_forma_ilegal.css'>
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