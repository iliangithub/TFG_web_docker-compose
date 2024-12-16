document.addEventListener('DOMContentLoaded', function() {
    var inputUsuario2 = document.getElementById('usuario_inicioses');
    var inputContrasena2 = document.getElementById('contrasena_inicioses');
    var mensajeErrorCaracteresEspeciales2 = document.getElementById('mensaje_error10');
    var mensajeErrorMayusculas2 = document.getElementById('mensaje_error11');
    var mensajeErrorLongitudUsuario2 = document.getElementById('mensaje_error12');
    var mensajeErrorLongitudContrasena2 = document.getElementById('mensaje_error13');

    // Agregar event listeners para los campos de entrada
    inputUsuario2.addEventListener('input', validarUsuario);
    inputContrasena2.addEventListener('input', validarContrasena);

    function validarUsuario() {
        var usuario2 = inputUsuario2.value; // No eliminar espacios en blanco al principio y al final
        var caracteresEspeciales2 = /[!#$%^&*()+=\[\]{};':"\\|,<>\/?~·¨´ñ`\s]/; // Caracteres especiales prohibidos incluyendo espacios

        var longitudValida2 = usuario2.length >= 4 && usuario2.length <= 30;

        // Validar caracteres especiales en el usuario
        if (usuario2 === '') { // Comprobar si el campo está vacío sin usar trim()
            mensajeErrorCaracteresEspeciales2.classList.remove('mensaje_error_input_activado');
            mensajeErrorMayusculas2.classList.remove('mensaje_error_input_activado');
            mensajeErrorLongitudUsuario2.classList.remove('mensaje_error_input_activado');
        } else {
            if (caracteresEspeciales2.test(usuario2) || usuario2.includes(' ')) {
                mensajeErrorCaracteresEspeciales2.classList.add('mensaje_error_input_activado');
            } else {
                mensajeErrorCaracteresEspeciales2.classList.remove('mensaje_error_input_activado');
            }

            // Validar mayúsculas en el usuario
            if (/[A-Z]/.test(usuario2)) {
                mensajeErrorMayusculas2.classList.add('mensaje_error_input_activado');
            } else {
                mensajeErrorMayusculas2.classList.remove('mensaje_error_input_activado');
            }

            // Validar longitud del usuario
            if (!longitudValida2) {
                mensajeErrorLongitudUsuario2.classList.add('mensaje_error_input_activado');
            } else {
                mensajeErrorLongitudUsuario2.classList.remove('mensaje_error_input_activado');
            }
        }
    }

    function validarContrasena() {
        var contrasena2 = inputContrasena2.value.trim(); // Eliminar espacios en blanco al principio y al final
        var longitudValida2 = contrasena2.length >= 4 && contrasena2.length <= 20;

        // Validar longitud de la contraseña
        if (contrasena2 === '') {
            mensajeErrorLongitudContrasena2.classList.remove('mensaje_error_input_activado');
        } else {
            if (!longitudValida2) {
                mensajeErrorLongitudContrasena2.classList.add('mensaje_error_input_activado');
            } else {
                mensajeErrorLongitudContrasena2.classList.remove('mensaje_error_input_activado');
            }
        }
    }
});
