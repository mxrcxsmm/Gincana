// Validar Nombre
function validarNombre() {
    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const errorNombre = document.getElementById('errorNombre');
    if (!nombre) {
        errorNombre.textContent = 'El nombre es obligatorio.';
    } else if (nombre.length < 3) {
        errorNombre.textContent = 'El nombre debe tener al menos 3 caracteres.';
    } else {
        errorNombre.textContent = '';
    }
}

// Validar Email
function validarEmail() {
    const email = document.querySelector('input[name="email"]').value.trim();
    const errorEmail = document.getElementById('errorEmail');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!email) {
        errorEmail.textContent = 'El email es obligatorio.';
    } else if (!emailPattern.test(email)) {
        errorEmail.textContent = 'El email no es válido.';
    } else {
        errorEmail.textContent = '';
    }
}

// Validar Contraseña
function validarPassword() {
    const password = document.querySelector('input[name="password"]').value.trim();
    const errorPassword = document.getElementById('errorPassword');

    if (!password) {
        errorPassword.textContent = 'La contraseña es obligatoria.';
    } else if (password.length < 6) {
        errorPassword.textContent = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        errorPassword.textContent = '';
    }
}

// Validar Confirmación de Contraseña
function validarConfirmarPassword() {
    const password = document.querySelector('input[name="password"]').value.trim();
    const confirmPassword = document.querySelector('input[name="password_confirmation"]').value.trim();
    const errorConfirmar = document.getElementById('errorConfirmar');

    if (!confirmPassword) {
        errorConfirmar.textContent = 'Debes confirmar la contraseña.';
    } else if (confirmPassword !== password) {
        errorConfirmar.textContent = 'Las contraseñas no coinciden.';
    } else {
        errorConfirmar.textContent = '';
    }
}

// Validar todo el formulario antes de enviarlo
document.getElementById('registroForm').addEventListener('submit', function(event) {
    validarNombre();
    validarEmail();
    validarPassword();
    validarConfirmarPassword();

    const errores = [
        document.getElementById('errorNombre').textContent,
        document.getElementById('errorEmail').textContent,
        document.getElementById('errorPassword').textContent,
        document.getElementById('errorConfirmar').textContent
    ];

    if (errores.some(error => error !== '')) {
        event.preventDefault();
    }
});