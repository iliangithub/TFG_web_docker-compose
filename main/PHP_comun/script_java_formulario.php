<?php
/*En resumen, como de costumbre, para ahorrar lineas de código, pongo aquí
el script
sirve para refrescar la página solita sin dar F5
y para que el formulario no se vuelve a enviar es decir
que no se compren 2 veces una misma cosa a la hora de refrescar*/

echo "<script>
			history.replaceState(null,null,location.pathname)
			location.reload();
		  </script>";

?>