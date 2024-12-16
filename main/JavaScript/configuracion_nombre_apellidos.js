document.addEventListener('DOMContentLoaded', function() {
    var inputNombre = document.getElementById('nombre_id');
    var inputPrimerApellido = document.getElementById('primerapellido_id');
    var inputSegundoApellido = document.getElementById('segundoapellido_id');

    var mensajeErrorNombre = document.getElementById('mensaje_error5');
    var mensajeErrorPrimerApellido = document.getElementById('mensaje_error6');
    var mensajeErrorSegundoApellido = document.getElementById('mensaje_error7');

    var mensajeErrorNombreNumeros = document.getElementById('mensaje_error13');
    var mensajeErrorPrimerApellidoNumeros = document.getElementById('mensaje_error14');
    var mensajeErrorSegundoApellidoNumeros = document.getElementById('mensaje_error15');

    var mensajeErrorNombreLongitud = document.getElementById('mensaje_error55');
    var mensajeErrorPrimerApellidoLongitud = document.getElementById('mensaje_error56');
    var mensajeErrorSegundoApellidoLongitud = document.getElementById('mensaje_error57');

    var caracteresEspeciales = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~·]+/;
    var numeros = /\d/;

    inputNombre.addEventListener('input', function() {
        validateField(inputNombre, mensajeErrorNombre, mensajeErrorNombreNumeros, mensajeErrorNombreLongitud, caracteresEspeciales, numeros);
    });

    inputPrimerApellido.addEventListener('input', function() {
        validateField(inputPrimerApellido, mensajeErrorPrimerApellido, mensajeErrorPrimerApellidoNumeros, mensajeErrorPrimerApellidoLongitud, caracteresEspeciales, numeros);
    });

    inputSegundoApellido.addEventListener('input', function() {
        validateField(inputSegundoApellido, mensajeErrorSegundoApellido, mensajeErrorSegundoApellidoNumeros, mensajeErrorSegundoApellidoLongitud, caracteresEspeciales, numeros);
    });

    function validateField(input, mensajeErrorEspeciales, mensajeErrorNumeros, mensajeErrorLongitud, regexEspeciales, regexNumeros) {
        var value = input.value;
        var error = false;

        if (value === '') {
            input.style.border = ''; // Restablece el borde al valor por defecto
            mensajeErrorLongitud.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorLongitud.classList.add('formulario_mensaje_error_del_input_desactivado');
            mensajeErrorEspeciales.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorEspeciales.classList.add('formulario_mensaje_error_del_input_desactivado');
            mensajeErrorNumeros.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorNumeros.classList.add('formulario_mensaje_error_del_input_desactivado');
            return;
        }

        if (value.length < 3 || value.length > 30) {
            input.style.border = '3px solid #bb2929';
            mensajeErrorLongitud.classList.add('formulario_mensaje_error_del_input_activado');
            mensajeErrorLongitud.classList.remove('formulario_mensaje_error_del_input_desactivado');
            error = true;
        } else {
            mensajeErrorLongitud.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorLongitud.classList.add('formulario_mensaje_error_del_input_desactivado');
        }

        if (regexEspeciales.test(value)) {
            input.style.border = '3px solid #bb2929';
            mensajeErrorEspeciales.classList.add('formulario_mensaje_error_del_input_activado');
            mensajeErrorEspeciales.classList.remove('formulario_mensaje_error_del_input_desactivado');
            error = true;
        } else {
            mensajeErrorEspeciales.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorEspeciales.classList.add('formulario_mensaje_error_del_input_desactivado');
        }

        if (regexNumeros.test(value)) {
            input.style.border = '3px solid #bb2929';
            mensajeErrorNumeros.classList.add('formulario_mensaje_error_del_input_activado');
            mensajeErrorNumeros.classList.remove('formulario_mensaje_error_del_input_desactivado');
            error = true;
        } else {
            mensajeErrorNumeros.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorNumeros.classList.add('formulario_mensaje_error_del_input_desactivado');
        }

        if (!error) {
            input.style.border = ''; // Restablece el borde al valor por defecto
        }
    }
});
