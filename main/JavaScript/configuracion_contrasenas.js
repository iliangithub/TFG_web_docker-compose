document.addEventListener('DOMContentLoaded', function() {
    var contrasenaNueva1 = document.getElementById('contrasena_nueva1');
    var contrasenaNueva2 = document.getElementById('contrasena_nueva2');
    var contrasenaantigua= document.getElementById('contrasena_antigua');
    var mensajeErrorcontrasenalongitud = document.getElementById('mensaje_error2');
    var mensajeErrorcontrasenanocoincide = document.getElementById('mensaje_error3');

    contrasenaNueva1.addEventListener('input', comparePasswords);
    contrasenaNueva2.addEventListener('input', comparePasswords);

    function comparePasswords() {
        var password1 = contrasenaNueva1.value;
        var password2 = contrasenaNueva2.value;
        
        if (password1.length < 4 || password1.length > 20) {
            contrasenaNueva1.classList.remove('input_formulario_cuando_de_error', 'input_formulario_cuando_coinciden');  
            contrasenaNueva1.classList.add('input_formulario_cuando_de_error');
            mensajeErrorcontrasenalongitud.classList.add('formulario_mensaje_error_del_input_activado');
        } else {
            contrasenaNueva1.classList.remove('input_formulario_cuando_de_error', 'input_formulario_cuando_coinciden');
            mensajeErrorcontrasenalongitud.classList.remove('formulario_mensaje_error_del_input_activado');
            contrasenaNueva1.classList.add('input_formulario_cuando_coinciden');
        }

        if (password1 === '' && password2 === '') {
            contrasenaNueva1.classList.remove('input_formulario_cuando_de_error', 'input_formulario_cuando_coinciden');
            contrasenaNueva2.classList.remove('input_formulario_cuando_de_error', 'input_formulario_cuando_coinciden');
            mensajeErrorcontrasenanocoincide.classList.remove('formulario_mensaje_error_del_input_activado');
            mensajeErrorcontrasenalongitud.classList.remove('formulario_mensaje_error_del_input_activado');
            //y para asegurarme de que no voy a ver los mensajes, pongo tambien el class de cuando desaparece
            mensajeErrorcontrasenanocoincide.classList.add('formulario_mensaje_error_del_input_desactivado');
            mensajeErrorcontrasenalongitud.classList.add('formulario_mensaje_error_del_input_desactivado');
            return;
        }

        if (password1 !== password2) {
            contrasenaNueva2.classList.remove('input_formulario_cuando_coinciden');
            contrasenaNueva2.classList.remove('input_formulario_cuando_de_error');
            contrasenaNueva2.classList.add('input_formulario_cuando_de_error');
            mensajeErrorcontrasenanocoincide.classList.add('formulario_mensaje_error_del_input_activado');
        } else {
            mensajeErrorcontrasenanocoincide.classList.remove('formulario_mensaje_error_del_input_activado');
            contrasenaNueva2.classList.remove('input_formulario_cuando_de_error');
            contrasenaNueva2.classList.remove('input_formulario_cuando_coinciden');
            contrasenaNueva2.classList.add('input_formulario_cuando_coinciden');
        }
    }
});
