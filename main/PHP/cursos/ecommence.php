<?php
session_start();

if (isset($_SESSION['valid_user'])) {
	include '../../PHP_comun/sesionname_variable.php';

}
?>

<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Curso Avanzado de eCommerce Online - eCommerce - eCommerce desde cero</title>
		<link rel="stylesheet" href="ecommence.css">
        <link rel="icon" type="image/x-icon" href="../../IMAGENES/fav.ico">
		<link rel="stylesheet" href="../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
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
                            <li><a href="trading.php">Trading</a></li>
                            <li><a href="ecommence.php">eCommerce</a></li>
                            <li><a href="comprar_cursos.php">Comprar</a></li>
                        </ul>
                    </li>
                    <li><a href="../../index.php">Menú principal</a></li>
                    <li><a href="../contacto/contacto.php">Contacto</a></li>
<?php							
if (isset($_SESSION['valid_user'])) {							
echo "              <li><a href='#'>Usuario: " . $usuario_actual . "</a>
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
        </header>";

}else{
		echo	"<li><a href='../../PHP/iniciosesion/iniciosesionyregistro.php'>Inicio de sesión</a></li>
			</ul>	
		</nav>
    </header>";

}
?>		  

<main>
    <div class="texto_medio">
        Curso Avanzado de eCommerce <br>
        Programa Avanzado de eCommerce <span role='img' aria-label='Emoticono de carrito de la compra'>🛒</span>
    </div>
</main>



<section>
    <h1>Análisis profesional y operativa</h1>
    <div class='centrar'>
        <div class='grid_parte_negra'>
            <p>
                Este programa quiere transmitir al alumno lo que nosotros como traders
                profesionales hacemos día a día. Por ello, compartiremos con vosotros
                nuestra visión del mercado, nuestra forma de interpretarlo y la forma de operar.<br><br>
                
                Para ello, os entregaremos nuestras estrategias: Intradía, swing y
                operativa de noticias, para que los estudiantes puedan operar tal y como
                nosotros lo hacemos. Además, enseñaremos las claves de la gestión
                monetaria y gestión de riesgo que nos han llevado a tener un porcentaje.
            </p>
            <p>
                Con un éxito superior al 85% para nuestra estrategia intraDía y superior al 90%
                para nuestra estrategia de posicionamiento. En ambos casos conseguido
                durante el primer semestre del 2016.
                Estos porcentajes están AUDITADOS, al igual que nuestra operativa sobre
                CUENTAS REALES. Si tienes cualquier duda o quieres ampliar
                información, siéntete libre de solicitarla a <a href="mailto:iililub419@iescanovas.es">iililub419@iescanovas.es</a>
            </p>
        </div>
    </div>
</section>

<aside>
    <h1>¿Qué incluye este curso?</h1>
    <div class='centrar'>
        <div class='grid_parte_naranja'>
            <ul>
                <li>31 clases grabadas online</li>
                <li>300h Trading Rooms</li>
                <li>Clases en directo</li>
                <li>Diploma Certificado</li>
                <li>Plataforma demo gratuita</li>
            </ul>
            <ul>
                <li>Tests de seguimiento</li>
                <li>Tutorías personalizadas</li>
                <li>Apto para todos los niveles</li>
                <li>Material complementario</li>
                <li>Acceso multiplataforma</li>
            </ul>
        </div>
    </div>
</aside>

<section>
    <h1>¿Cómo se imparte este curso de eCommerce online?</h1>
    <div class='centrar'>
        <div class='grid_parte_negra'>
            <p>
                Avanza en conocimiento y asiste a las eCommerce Rooms en directo
                Debido a la especialización de este curso de trading, el mismo se
                imparte de forma 100% online a través de clases grabadas. De esta
                forma el estudiante podrá progresar a su ritmo y parar o retroceder
                tantas veces como desee. El acceso a este curso ofrece seguimiento
                continuado por parte de nuestros profesores, por lo que se podrán
                resolver las dudas vía e-mail, telefónicamente o a través de Team
                Viewer, dependiendo de la naturaleza de la duda.
            </p>
            <div>
                <img src="../../IMAGENES/ecommerce2.jpg">
            </div>
        </div>
    </div>
</section>

<footer>
    <div>
    <h1>Nuestros cursos:</h1>
    <div class='centrar'>
        <div>
            <ul>
                <li>Módulo 1: Introducción al comercio electrónico</li>
                <li>Módulo 2: Investigación</li>
                <li>Módulo 3: Mejores prácticas Benchmarking (aprendizaje de los competidores)</li>
                <li>Módulo 4: Método CANVAS</li>
                <li>Módulo 5: Técnicas LEAN</li>
                <li>Módulo 6: Digitalización de negocios existentes</li>
                <li>Módulo 7: Productos digitales</li>
                <li>Módulo 8: Multiplataforma</li>
                <li>Módulo 9: Disrupción</li>
                <li>Módulo 10: Fijación de precios</li>
                <li>Módulo 11: Logística</li>
                <li>Módulo 12: Fiscalidad</li>
                <li>Módulo 13: Ofertas locales</li>
                <li>Módulo 14: Tipos de redes sociales</li>
            </ul>
            <div class='centrar_enlace_comprar'>
                <a href=comprar_cursos.php>Comprar aquí los cursos</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

