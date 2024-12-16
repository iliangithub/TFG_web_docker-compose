/*ESTE JAVASCRIPT LO ESTOY UTILIZANDO EXCLUSIVAMENTE PARA LA BARRA DEL NAVEGADOR
CUANDO LA PANTALLA ES DE 804 PX*/

function toggleMenu() {
    const nav = document.querySelector('nav ul');
    const menuButton = document.getElementById('boton_hamburguesa_js');
    const closeButton = document.getElementById('boton_x_js');

    if (window.innerWidth <= 804) {
        if (nav.style.display === 'block') {
            nav.style.display = 'none';
            closeButton.style.display = 'none';
            menuButton.style.display = 'block';
        } else {
            nav.style.display = 'block';
            closeButton.style.display = 'block';
            menuButton.style.display = 'none';
        }
    }
}

function closeMenu() {
    const nav = document.querySelector('nav ul');
    const menuButton = document.getElementById('boton_hamburguesa_js');
    const closeButton = document.getElementById('boton_x_js');

    if (window.innerWidth <= 804) {
        nav.style.display = 'none';
        menuButton.style.display = 'block';
        closeButton.style.display = 'none';
    }
}

// Add event listener to handle resize
window.addEventListener('resize', function() {
    const nav = document.querySelector('nav ul');
    const menuButton = document.getElementById('boton_hamburguesa_js');
    const closeButton = document.getElementById('boton_x_js');

    if (window.innerWidth > 804) {
        nav.style.display = 'flex';
        menuButton.style.display = 'none';
        closeButton.style.display = 'none';
    } else {
        nav.style.display = 'none';
        menuButton.style.display = 'block';
        closeButton.style.display = 'none';
    }
});

// Initialize menu state on load
document.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('nav ul');
    const menuButton = document.getElementById('boton_hamburguesa_js');
    const closeButton = document.getElementById('boton_x_js');

    if (window.innerWidth <= 804) {
        nav.style.display = 'none';
        menuButton.style.display = 'block';
        closeButton.style.display = 'none';
    } else {
        nav.style.display = 'flex';
        menuButton.style.display = 'none';
        closeButton.style.display = 'none';
    }
});
