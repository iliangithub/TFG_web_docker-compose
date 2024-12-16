
# Página Web + Docker Compose - PHP + JavaScript 2024

Este es la parte final de mi TFG presentado en 2024, para el Grado Superior **Administración de sistemas informáticos en Red**
Además de que es la parte más importante y como el motivo final por el que se hizo el trabajo, al principio se hizo en XAMPP para facilitar la visualización y que todo funcione a la primera.

> [!IMPORTANT]   
> Por favor, NO UTILIZAR O COPIAR como Proyecto de TFG para futuros años.

# Introducción + Prerrequisitos

Primero, como he mencionado antes esta es la parte final del proyecto y la parte más importante, el XAMPP lo utilice en caso de que algo no funciona aquí a la hora de montar la imagen o tarde mucho, ha sido utilizado a modo de soporte, pero el producto FINAL AL CLIENTE ES ESTA.

## Prerrequisitos:

Es opcional pero altamente recomendable tener mysql_workbench para poder hacer una conexión al contenedor que tiene la BD y ver que realmente funciona pero no es para nada necesario.
Basta con mostrar las BD que hay creadas para ver que está todo correcto, tenemos que encontrar una llamada "tfg_ilian_docker_compose" ejecutamos:

```
SHOW DATABASES;
```

Docker desktop es también muy recomendable, pues podemos ver visualmente como se han creado el contendor y dentro pues los dos contenedores de apache y mariaDB.

Para que funcione, recomendamos también usar la linea de comandos de Visual Studio Code.

## Introducción.

Para que funcione simplemente, lo descargamos y abrimos la carpeta desde "VSC". Evidentemente tenemos que abrirlo desde la carpeta "TFG_Definitivo_docker_compose" y dentro de ella ejecutamos el comando, para ello, en el VSC arriba a la derecha en la terminal, escribimos el comando: 
```
docker-compose up --build
```
y ya automáticamente hará todo por nosotros, es 100% automático.

Si por alguna casualidad quieres comprobar que todo vaya bien, ve al dockerdesktop y comprueba dentro del contendor los dos contenedores creados y ** QUE ESTÉN CORRIENDO** (mira el icono de pausa y start) si hay algun apagado pues enciendelo e ya.

Te diriges a tu navegador de preferencia:

http://localhost/

e ya. Eso fue todo.

> [!TIP]
> Si quieres una guía exacta y una documentación exacta de todo,
> de todos los errores, de cada cosa y detalle se encuentran en la carpeta documentación, es un PDF.

# Cómo trabajar con él.
> [!TIP]
> En caso de querer editarlo, no hace falta que hagues docker build ni nada cada 2x3, simplemente ve editando cada cosa, refresca la caché del navegador si hace falta e ya. No hay que hacer nada en especial.
>
