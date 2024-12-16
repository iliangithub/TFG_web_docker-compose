/*este js es utilizado por configuracion en la parte de telefono y direccion */

document.addEventListener('DOMContentLoaded', function() {
    var inputTelefono = document.getElementById('telefono_id');
    var mensajeErrorTelefonoLongitud = document.getElementById('mensaje_error4');
    var mensajeErrorTelefefonoCaracteresEspeciales = document.getElementById('mensaje_error10');
    var mensajeErrorTelefonoNoPuedeLlevarLetras = document.getElementById('mensaje_error9');

    var inputDireccion = document.getElementById('direccion_id');
    var mensajeErrorDireccionEspeciales = document.getElementById('mensaje_error8');

   

    var caracteresEspeciales = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~·]+/;
    var letras = /[a-zA-Z]/;
    var numeros = /\d/;

    // Añade un listener de eventos para el campo de teléfono
    inputTelefono.addEventListener('input', validateTelefono);

    // Añade un listener de eventos para el campo de dirección
    inputDireccion.addEventListener('input', validateDireccion);


    function validateTelefono() {
        var telefono = inputTelefono.value;

        if (telefono === '') {
            // Si el campo de teléfono está vacío, eliminar el borde rojo y los mensajes de error
            inputTelefono.classList.remove('input_formulario_cuando_de_error');
            inputTelefono.classList.remove('input_formulario_cuando_coinciden');
            mensajeErrorTelefonoLongitud.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorTelefefonoCaracteresEspeciales.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorTelefonoNoPuedeLlevarLetras.classList.remove('formulario_mensaje_error_del_input_activado');
            return;
        }

        if (telefono.length < 7 || telefono.length > 14) {
            // Si la longitud del teléfono no está dentro del rango, aplicar estilo de error y mostrar el mensaje correspondiente
            inputTelefono.classList.remove('input_formulario_cuando_coinciden');
            inputTelefono.classList.add('input_formulario_cuando_de_error');
            mensajeErrorTelefonoLongitud.classList.add('formulario_mensaje_error_del_input_activado');
        } else {
            // Si la longitud del teléfono está dentro del rango, aplicar estilo de éxito y ocultar el mensaje de error
            inputTelefono.classList.remove('input_formulario_cuando_de_error');
            inputTelefono.classList.add('input_formulario_cuando_coinciden');
            mensajeErrorTelefonoLongitud.classList.remove('formulario_mensaje_error_del_input_activado');
        }

        if (caracteresEspeciales.test(telefono)) {
            // Si el teléfono contiene caracteres especiales, aplicar estilo de error y mostrar el mensaje correspondiente
            inputTelefono.classList.remove('input_formulario_cuando_coinciden');
            inputTelefono.classList.add('input_formulario_cuando_de_error');
            mensajeErrorTelefefonoCaracteresEspeciales.classList.add('formulario_mensaje_error_del_input_activado');
        } else {
            // Si el teléfono no contiene caracteres especiales, ocultar el mensaje de error correspondiente
            mensajeErrorTelefefonoCaracteresEspeciales.classList.remove('formulario_mensaje_error_del_input_activado');
        }

        if (letras.test(telefono)) {
            // Si el teléfono contiene letras, aplicar estilo de error y mostrar el mensaje correspondiente
            inputTelefono.classList.remove('input_formulario_cuando_coinciden');
            inputTelefono.classList.add('input_formulario_cuando_de_error');
            mensajeErrorTelefonoNoPuedeLlevarLetras.classList.add('formulario_mensaje_error_del_input_activado');
        } else {
            // Si el teléfono no contiene letras, ocultar el mensaje de error correspondiente
            mensajeErrorTelefonoNoPuedeLlevarLetras.classList.remove('formulario_mensaje_error_del_input_activado');
        }
    }

    function validateDireccion() {
        var direccion = inputDireccion.value;

        if (caracteresEspeciales.test(direccion)) {
            // Si la dirección contiene caracteres especiales, aplicar estilo de error y mostrar el mensaje correspondiente
            inputDireccion.classList.add('input_formulario_cuando_de_error');
            mensajeErrorDireccionEspeciales.classList.add('formulario_mensaje_error_del_input_activado');
        } else {
            // Si la dirección no contiene caracteres especiales, eliminar el estilo de error y ocultar el mensaje correspondiente
            inputDireccion.classList.remove('input_formulario_cuando_de_error');
            mensajeErrorDireccionEspeciales.classList.remove('formulario_mensaje_error_del_input_activado');
        }
    }

});
