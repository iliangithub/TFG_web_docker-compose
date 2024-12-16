/*
el html que usé:
<body>
    <div class='cartelito_error_desactivado'>Error</div>

    <input type='submit' name='boton' id='miBoton'>


</body>

Seleccionar el botón y el cartelito de error*/
const boton = document.getElementById('miBoton');
const cartelitoError = document.querySelector('.cartelito_error_desactivado');

// Agregar un evento click al botón
boton.addEventListener('click', () => {
    // Cambiar la clase del cartelito para activarlo
    cartelitoError.classList.remove('cartelito_error_desactivado');
    cartelitoError.classList.add('cartelito_error_activado');

    // Después de 5 segundos, volver a ocultar el cartelito de error
    // Después de 5 segundos, mover el cartelito hacia la derecha
setTimeout(() => {
    cartelitoError.classList.remove('cartelito_error_desactivado');
    cartelitoError.classList.remove('cartelito_error_activado');
    cartelitoError.classList.add('cartelito_error_desaparecer');
}, 5000); // 5000 milisegundos = 5 segundos

});
