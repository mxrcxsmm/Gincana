document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    // Verificar si los elementos existen
    if (!emailInput || !passwordInput || !emailError || !passwordError) {
        console.error('Error: No se encontraron algunos elementos del DOM.');
        return;
    }

    // Función para validar el correo electrónico
    function validateEmail() {
        const email = emailInput.value.trim();
        if (!email) {
            emailError.textContent = 'El correo electrónico es requerido.';
            emailError.classList.remove('hidden');
            return false;
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            emailError.textContent = 'El correo electrónico no es válido.';
            emailError.classList.remove('hidden');
            return false;
        } else {
            emailError.classList.add('hidden');
            return true;
        }
    }

    // Función para validar la contraseña
    function validatePassword() {
        const password = passwordInput.value.trim();
        if (!password) {
            passwordError.textContent = 'La contraseña es requerida.';
            passwordError.classList.remove('hidden');
            return false;
        } else if (password.length < 6) {
            passwordError.textContent = 'La contraseña debe tener al menos 6 caracteres.';
            passwordError.classList.remove('hidden');
            return false;
        } else {
            passwordError.classList.add('hidden');
            return true;
        }
    }

    // Función para mostrar SweetAlert2
    function showErrorAlert(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error de autenticación',
            text: message,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    }

    // Validar el formulario antes de enviarlo
    loginForm.addEventListener('submit', function (event) {
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();

        if (!isEmailValid || !isPasswordValid) {
            event.preventDefault(); // Evitar el envío del formulario si hay errores

            // Mostrar SweetAlert2 si hay errores
            if (!isEmailValid) {
                showErrorAlert(emailError.textContent);
            } else if (!isPasswordValid) {
                showErrorAlert(passwordError.textContent);
            }
        }
    });

    // Validar el correo electrónico cuando se pierde el foco (onblur)
    emailInput.addEventListener('blur', validateEmail);

    // Validar la contraseña cuando se pierde el foco (onblur)
    passwordInput.addEventListener('blur', validatePassword);
});