/*Este js es utilizado por "recuperar_contraseña.php
cuando te salen los dos inputs de contraseña para crear así una nueva*/

document.addEventListener('DOMContentLoaded', function() {
    var input_contrasena1 = document.getElementById('input_contrasena1');
    var input_contrasena2 = document.getElementById('input_contrasena2');

    var mensaje_pocos_caracteres = document.getElementById('mensaje_error_poco_caracteres');
    var mensaje_error_iguales = document.getElementById('mensaje_error_iguales');

    // Agregar event listeners para los campos de entrada
    input_contrasena1.addEventListener('input', validar_input_1);
    input_contrasena2.addEventListener('input', validar_input_2);

    function validar_input_1() {
        var contrasena1 = input_contrasena1.value;

        if (contrasena1 === "") {
            resetear_estilos(input_contrasena1, mensaje_pocos_caracteres);
        } else if (contrasena1.length < 4 || contrasena1.length > 20) {
            mensaje_pocos_caracteres.classList.add('mensaje_error_por_defecto_activado');
            input_contrasena1.classList.add('input_contrasena_error');
            input_contrasena1.classList.remove('input_contrasena_correcto');
        } else {
            mensaje_pocos_caracteres.classList.remove('mensaje_error_por_defecto_activado');
            input_contrasena1.classList.remove('input_contrasena_error');
            input_contrasena1.classList.add('input_contrasena_correcto');
        }

        validar_igualdad_contrasenas();
    }

    function validar_input_2() {
        var contrasena2 = input_contrasena2.value;

        if (contrasena2 === "") {
            resetear_estilos(input_contrasena2, mensaje_error_iguales);
        } else {
            validar_igualdad_contrasenas();
        }
    }

    function validar_igualdad_contrasenas() {
        var contrasena1 = input_contrasena1.value;
        var contrasena2 = input_contrasena2.value;

        if (contrasena1 !== "" && contrasena2 !== "" && contrasena1 !== contrasena2) {
            mensaje_error_iguales.classList.add('mensaje_error_por_defecto_activado');
            input_contrasena2.classList.add('input_contrasena_error');
            input_contrasena2.classList.remove('input_contrasena_correcto');
        } else if (contrasena1 === contrasena2 && contrasena2 !== "") {
            mensaje_error_iguales.classList.remove('mensaje_error_por_defecto_activado');
            input_contrasena2.classList.remove('input_contrasena_error');
            input_contrasena2.classList.add('input_contrasena_correcto');
        }
    }

    function resetear_estilos(input, mensaje) {
        input.classList.remove('input_contrasena_error');
        input.classList.remove('input_contrasena_correcto');
        mensaje.classList.remove('mensaje_error_por_defecto_activado');
    }
});
