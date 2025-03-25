<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">    
</head>

<body>
    <div class="login-container">
        <img class="imagen" src="{{ asset('img/logo.png') }}" alt="Inspector Gadget">
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="form-group">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" value="{{ old('nombre') }}" onblur="validarNombre()">
                @if ($errors->has('nombre'))
                    <span class="text-danger">{{ $errors->first('nombre') }}</span>
                @endif
                <p id="errorNombre" class="text-danger"></p>
            </div>

            <!-- Email -->
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" onblur="validarEmail()">
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <p id="errorEmail" class="text-danger"></p>
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" onblur="validarPassword()">
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <p id="errorPassword" class="text-danger"></p>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" onblur="validarConfirmarPassword()">
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
                <p id="errorConfirmar" class="text-danger"></p>
            </div>

            <!-- Botón de Registro -->
            <button type="submit" class="btn btn-primary btn-block">REGISTRARME</button>
        </form>
        <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión aquí</a>
    </div>

    <script src="{{ asset('js/validaciones.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>