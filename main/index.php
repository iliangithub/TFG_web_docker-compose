<?php
session_start();

if (isset($_SESSION['valid_user'])) {
	include './PHP_comun/sesionname_variable.php';
}
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Curso de trading ¡50 primeras plazas gratis! Trading desde cero</title>
<?php
    if (isset($_SESSION['valid_user'])) {
echo "<link rel='stylesheet' href='style_2.css'>"; //cuando has iniciado sesion...
    }else{
echo "<link rel='stylesheet' href='style.css'>"; //cuando no has iniciado sesion
    }
?>  
    <link rel="icon" type="image/x-icon" href="IMAGENES/fav.ico">
    <link rel="stylesheet" href="CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
    <script src="JavaScript/desplegar_navegador_vertical.js"></script>
</head>
<body>
    <header>
        <nav>
        <button class='boton_hamburguesa_class' id='boton_hamburguesa_js' onclick='toggleMenu()'>☰</button>
            <button class='boton_cerrar_class' id='boton_x_js' onclick='closeMenu()'>✖</button>
            <ul>
                <li><a href="PHP/canjeatucupon/canjea_tu_cupon.php">Canjea tu cupón</a></li>
                <li><a href="#">Cursos</a>
                    <ul>
                        <li><a href="PHP/cursos/trading.php">Trading</a></li>
                        <li><a href="PHP/cursos/ecommence.php">eCommerce</a></li>
                        <li><a href="PHP/cursos/comprar_cursos.php">Comprar</a></li>
                    </ul>
                </li>
                <li><a href="index.php">Menú principal</a></li>
                <li><a href="PHP/contacto/contacto.php">Contacto</a></li>
<?php
if (isset($_SESSION['valid_user'])) {
    echo "      <li><a href='#'>Usuario: " . $usuario_actual . "</a>
                    <ul>
                        <li><a href='PHP/iniciosesion/logout.php'>Cerrar sesión</a></li>
                        <li><a href='PHP/usuario/configuracion.php'>Configuración</a></li>
                        <li><a href='PHP/usuario/mi_carrito.php'>Mi Carrito 🛒</a></li>
                        <li><a href='PHP/usuario/mis_cursos.php'>Mis cursos</a></li>
                        <li> <a href='PHP/usuario/ver_mi_cartera.php'>Ver mi cartera</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <video autoplay loop muted playsinline class='background-video-index'>
				<source src='IMAGENES/index-menuprincipal2.mp4' type='video/mp4'>

                 <div class='titulo_parte_arriba'>
                ¡Bienvenido de nuevo " . $usuario_actual . "!<br>
                </div>
        </video>
        
            <div class='titulo_parte_arriba'>
            ¡Bienvenido de nuevo " . $usuario_actual . "!<br>
            </div>
        

        <article class='parte_abajo'>
            <div class='frase_1'>
            Crea el perfil de persona que siempre has deseado.
            </div>
            

            <div class='frase_2'>
            Construye tu futuro, la mejor versión de ti mismo.
            </div>

            <div class='frase_3'>
            Empieza a formarte.
            </div>
            
            <div class='centrar'>
                <a href='PHP/cursos/comprar_cursos.php'>Accede ya a nuestros cursos</a>
            </div>
        </article>
    </main>
    ";
} else {
                    echo "
                <li><a href='PHP/iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
            </ul>
        </nav>
    </header>

<section>
    <div class='texto_impactante'> 
        ¿CÓMO ES POSIBLE QUE ALGUIEN <br>
        SIN TENER IDEA DEL TRADING<br>
        SE CONVIERTA EN EL PRÓXIMO TIBURÓN EN BOLSA<br> 
        CON POCOS RECURSOS Y <u>POCO TIEMPO</u>?
        <p> UTILIZA EL MÉTODO ILIAN</p>
    </div>
    <div class='ver_curso_de_trading'>
        <a class='enlace' href='PHP/cursos/trading.php'>Ver curso de trading</a>
    </div>
</section>

<main>
    <div class='contenedor_parte_negra_centrar'>    
        <img src='IMAGENES/trading.jpg'>
        <div> <!-- el div este no es por la cara, lo hago para que el grid busque el proximo objeto mas cercano y cree y englobe a todos esas etiquetas como una única columna-->
            <span class='titulo_parte_negra'>Curso de Trading Online</span>
            <p>
            Trading Desde Cero (TDC) rompe con los moldes establecidos de la 
            formación tradicional en mercados financieros. En nuestra escuela de 
            trading online combinamos la formación teórica con sesiones de trading en 
            tiempo real con nuestro equipo de traders profesionales. El objetivo es 
            mostrar cómo aplicamos de forma práctica, en directo y con dinero real, las
            enseñanzas que impartimos durante nuestros curso de trading online.
            </p>
            <p>
            Esto fuerza a nuestro equipo a estar actualizado en conocimientos y
            operativa, lo que hace que tanto nuestra formación para invertir en bolsa,
            como las sesiones de trading room y el canal de señales de trading estén
            actualizados y mantengan un nivel alto de operativa y calidad.
            </p>
            <p>   
            Sea cual sea tu nivel y el interés que tengas por aprender a invertir en bolsa,
            tenemos lo que estás buscando. Trabajamos con todos los perfiles, tanto
            trading para principiantes como trading profesional. Todo lo que verás en 
            Trading Desde Cero se basa en nuestro propio conocimiento y experiencia
            en los mercados, tal y como mostramos durante las sesiones de trading
            online donde se opera en directo y con dinero real.
            </p>
        </div>
    </div>
</main>

<!-- Usar un elemento <aside></aside> incorporará texto que no pertenece a las secciones principales de tu sitio web, pero que debería aparecer en un área o sección establecida.-->
<aside>
    ¡50 plazas de nuestro curso de inversión en bolsa de Febrero Gratis!<br>
    <div class='contenedor_naranja_enlace'>
        <a href='PHP/cursos/trading.php'> Accede ahora </a>
    </div>
</aside>
        
<main>
    <div class='contenedor_parte_negra_centrar'>
        <div> <!-- el div este no es por la cara, lo hago para que el grid busque el proximo objeto
                    mas cercano y cree y englobe a todos esas etiquetas como una única columna-->
            <span class='titulo_parte_negra'>Curso de Trading</span>
            <p>
            Entre Trading Desde Cero y Benowu hemos creado este curso de trading con 
            un programa de inversión en bolsa para que cualquier persona pueda 
            comprender el funcionamiento, los pros y contras de esta manera de invertir.
            </p>
            <p>
            Hemos unido la formación teórica del curso de trading con Trading Rooms 
            donde se aprende de forma práctica la aplicación de los conocimientos 
            utilizando dinero real, no cuentas demo.
            </p>
            <p>
            El objetivo de la misma es hacer llegar información relevante, actualizada y 
            práctica a estudiantes de la misma Universidad y hacer que otras personas 
            que no pertenezcan a la misma se formen y conozcan el funcionamiento de 
            esta entidad educativa.
            </p>
        </div>  
        <div>     
            <img src='IMAGENES/trading2.png'>
        </div>
    </div>
</main>
</body>
</html>";
}
?>

