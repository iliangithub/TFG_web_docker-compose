document.addEventListener('DOMContentLoaded', function() {
    var inputUsuario = document.getElementById('input_error1');
    var inputContrasena = document.getElementById('input_error2');
    var inputEmail = document.getElementById('input_error_email');
    
    var mensajeErrorUsuarioCaracteresEspeciales = document.getElementById('mensaje_error1');
    var mensajeErrorUsuarioMayusculas = document.getElementById('mensaje_error3');
    var mensajeErrorUsuarioLongitud = document.getElementById('mensaje_error4');
    var mensajeErrorContrasenaLongitud = document.getElementById('mensaje_error2');

    var mensaje_email_caracteresesp = document.getElementById('mensaje_error51');
    var mensaje_email_mayusculas = document.getElementById('mensaje_error52');
    var mensaje_email_cantidad_caract = document.getElementById('mensaje_error53');
    var mensaje_email_debellevar_aroba = document.getElementById('mensaje_error54');

    inputUsuario.addEventListener('input', validateUsuario);
    inputContrasena.addEventListener('input', validateContrasena);
    inputEmail.addEventListener('input', validateEmail);

    function validateUsuario() {
        var usuario = inputUsuario.value;

        if (usuario === '') {
            // Si el campo de usuario está vacío, ocultar todos los mensajes de error
            mensajeErrorUsuarioCaracteresEspeciales.classList.remove('mensaje_error_input_activado');
            mensajeErrorUsuarioMayusculas.classList.remove('mensaje_error_input_activado');
            mensajeErrorUsuarioLongitud.classList.remove('mensaje_error_input_activado');
            return;
        }

        if (usuario.length < 4 || usuario.length > 30) {
            mensajeErrorUsuarioLongitud.classList.add('mensaje_error_input_activado');
        } else {
            mensajeErrorUsuarioLongitud.classList.remove('mensaje_error_input_activado');
        }

        // Verificar caracteres especiales y espacios
        var caracteresEspeciales = /[^A-Za-z0-9._]/;
        if (caracteresEspeciales.test(usuario) || usuario.includes(' ')) {
            mensajeErrorUsuarioCaracteresEspeciales.classList.add('mensaje_error_input_activado');
        } else {
            mensajeErrorUsuarioCaracteresEspeciales.classList.remove('mensaje_error_input_activado');
        }

        // Verificar mayúsculas
        var contieneMayusculas = /[A-Z]/.test(usuario);
        if (contieneMayusculas) {
            mensajeErrorUsuarioMayusculas.classList.add('mensaje_error_input_activado');
        } else {
            mensajeErrorUsuarioMayusculas.classList.remove('mensaje_error_input_activado');
        }
    }

    function validateContrasena() {
        var contrasena = inputContrasena.value;

        if (contrasena === '') {
            // Si el campo de contraseña está vacío, ocultar el mensaje de error
            mensajeErrorContrasenaLongitud.classList.remove('mensaje_error_input_activado');
            return;
        }

        // Verificar longitud de la contraseña
        if (contrasena.length < 4 || contrasena.length > 20) {
            mensajeErrorContrasenaLongitud.classList.add('mensaje_error_input_activado');
        } else {
            mensajeErrorContrasenaLongitud.classList.remove('mensaje_error_input_activado');
        }
    }

    function validateEmail() {
        var email = inputEmail.value;
    
        if (email === '') {
            // Si el campo de email está vacío, ocultar todos los mensajes de error
            mensaje_email_caracteresesp.classList.remove('mensaje_error_input_activado');
            mensaje_email_mayusculas.classList.remove('mensaje_error_input_activado');
            mensaje_email_cantidad_caract.classList.remove('mensaje_error_input_activado');
            mensaje_email_debellevar_aroba.classList.remove('mensaje_error_input_activado');
            return;
        }
    
        // Verificar si hay espacios en el email
        if (email.indexOf(' ') !== -1) {
            mensaje_email_caracteresesp.classList.add('mensaje_error_input_activado');
        } else {
            mensaje_email_caracteresesp.classList.remove('mensaje_error_input_activado');
        }
    
        // Verificar mayúsculas
        var contieneMayusculas = /[A-Z]/.test(email);
        if (contieneMayusculas) {
            mensaje_email_mayusculas.classList.add('mensaje_error_input_activado');
        } else {
            mensaje_email_mayusculas.classList.remove('mensaje_error_input_activado');
        }
        
        // Verificar caracteres especiales
        var caracteresNoPermitidos = /[!#$%^&*()+=\[\]{};':"\\|,<>\/?~·¨´ñ`]/;
        if (caracteresNoPermitidos.test(email)) {
            mensaje_email_caracteresesp.classList.add('mensaje_error_input_activado');
        } else {
            mensaje_email_caracteresesp.classList.remove('mensaje_error_input_activado');
        }
    
        // Verificar longitud del email
        if (email.length > 256 || email.length < 4) {
            mensaje_email_cantidad_caract.classList.add('mensaje_error_input_activado');
        } else {
            mensaje_email_cantidad_caract.classList.remove('mensaje_error_input_activado');
        }
    
        // Verificar que el email contenga un @
        if (!email.includes('@')) {
            mensaje_email_debellevar_aroba.classList.add('mensaje_error_input_activado');
        } else {
            mensaje_email_debellevar_aroba.classList.remove('mensaje_error_input_activado');
        }
    }
    
});
