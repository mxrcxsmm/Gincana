<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/validaciones.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    
</head>

<body>
    <div class="login-container">
        <img class="imagen" src="{{ asset('img/logo.png') }}" alt="Inspector Gadget">
        @if (session('status'))
            <div class="bg-green-100 text-green-600 p-3 rounded-lg mb-4">
                {{ session('status') }}
            </div>
            @endif
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" onblur="validarEmail()">
                <!-- Mensaje de error para el correo electrónico -->
                @error('email')
                <span id="emailError" class="text-danger @if(!$errors->has('email')) hidden @endif">
                    {{ $errors->first('email') }}
                </span>
                @enderror
                <p id="errorEmail" class="text-danger"></p>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña"  onblur="validarPassword()">
                
                <!-- Mensaje de error para la contraseña -->
                @error('password')
                <span id="passwordError" class="text-danger @if(!$errors->has('password')) hidden @endif">
                    {{ $errors->first('password') }}
                </span>
                @enderror
                <p id="errorPassword" class="text-danger"></p>
            </div>
            <button type="submit" class="btn btn-primary btn-block">ENTRAR</button>
        </form>
        <a href="{{ route('register') }}">¿Todavía sigues sin cuenta? Regístrate</a>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/login.js') }}"></script>
    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error de autenticación',
            text: "{{ session('error') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif
</body>
</html>
