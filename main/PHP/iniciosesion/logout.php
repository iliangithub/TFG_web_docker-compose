<?php
/*LLEGAMOS A ESTA PAGINA PARA CERRARLE LA SESION
HEMOS LLEGADO AQUÍ GRACIAS
A QUE EL CLIENTE QUIERE POR VOLUNTAD PROPIA CERRAR SESION*/


  session_start();
if(isset($_SESSION['valid_user'])) {
  $variable_de_sesion = $_SESSION['valid_user']; 
  /*ANULACIÓN DE LAS VARIABLES DE SESIÓN REGISTRADAS*/
  unset($_SESSION['valid_user']);

  /*ELIMINACIÓN DE LA SESIÓN*/
  session_destroy();
}
?>
<html>
    <head>
      <title>Cierre sesión</title>
      <meta charset="UTF-8">
      <link rel="stylesheet" href="../../CSS_comun/solo_la_barra_de_navegacion_de_arriba.css">
      <link rel="stylesheet" href="logout.css">
      <link rel="icon" type="image/x-icon" href="../../IMAGENES/fav.ico">
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
                              <li><a href="../cursos/comprar_cursos.php">Comprar</a></li>
                          </ul>
                      </li>
                      <li><a href='../../index.php'>Menú principal</a></li>
                      <li><a href='../contacto/contacto.php'>Contacto</a></li>
                      <li><a href='iniciosesionyregistro.php'>Inicio de sesión</a></li>
                  </ul>
              </nav>
          </header>
        

  <?php 
    if ($variable_de_sesion != NULL) {
      echo "<div class='contenedor'> Desconectado...<br>¡Borrando todas las cookies! Este proceso puede tardar un poco</div>
      <script>
      function redirigir() {
          window.location.href = 'iniciosesionyregistro.php';
      }

      setTimeout(redirigir, 3000);

      </script>
      ";

      /* "durante la ejecucion del script", php se ejecuta en el servidor y al terminar envia la salida al 
      cliente (navegador) por eso ves el retardo antes que cualquier salida.

      SE TIENE QUE HACER CON JAVASCRIPT SI QUISIERA EJECUTAR ALGO Y LUEGO ESPERAR
      sleep(2);
      */
    }else{
      /* En este else lo que estoy haciendo
      es que en caso de que alguien se le ocurra entrar
      en la pagina de cierre de sesion (esta) sin haber cerrado
      la sesion, que te mande del tirón al inicio de sesión*/
      header('Location: '.'iniciosesionyregistro.php');
      /*y tiene que estar así escrito*/

      /*tambien, en caso de alguien haber iniciado sesion
      luego, cerrado y luego al cerrar sesion se queda en la pagina
      y vuelve a refrescar, que lo mande a esa pagina*/

    }
  ?> 
  </body>
</html>
