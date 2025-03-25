@extends('layouts.app')

@section('title', 'Crear Etiqueta')

@section('content')
    <h2>Crear Etiqueta</h2>

    @if($errors->any())
      <div class="alert alert-danger" style="display: none;" id="serverErrors">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('admin.etiquetas.store') }}" method="POST" id="createEtiquetaForm">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}"  onblur="validateNombre()">
            <small id="nombreError" class="text-danger">@error('nombre') {{ $message }} @enderror</small>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}" placeholder="#FFFFFF"  onblur="validateColor()">
            <small id="colorError" class="text-danger">@error('color') {{ $message }} @enderror</small>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.etiquetas.index') }}" class="btn btn-secondary">Volver</a>
    </form>
@endsection

@section('scripts')
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Funciones de validación onblur para cada campo
function validateNombre() {
    var nombre = document.getElementById('nombre').value.trim();
    if(nombre === "") {
        document.getElementById('nombreError').textContent = "El nombre es obligatorio.";
    } else {
        document.getElementById('nombreError').textContent = "";
    }
}

function validateColor() {
    var color = document.getElementById('color').value.trim();
    // Validación simple: que el campo no esté vacío y empiece con "#" y tenga 7 caracteres (# + 6 dígitos/hex)
    if(color === "") {
        document.getElementById('colorError').textContent = "El color es obligatorio.";
    } else if(!/^#[0-9A-Fa-f]{6}$/.test(color)) {
        document.getElementById('colorError').textContent = "El formato de color debe ser #RRGGBB.";
    } else {
        document.getElementById('colorError').textContent = "";
    }
}

// Validación final al enviar el formulario
document.getElementById('createEtiquetaForm').addEventListener('submit', function(e) {
    // Ejecutamos las validaciones onblur para asegurarnos de que se actualicen los mensajes
    validateNombre();
    validateColor();

    // Revisamos si hay errores (buscamos algún <small> que tenga contenido)
    var errorElements = document.querySelectorAll('small.text-danger');
    var hasError = false;
    errorElements.forEach(function(el) {
        if(el.textContent.trim() !== "") {
            hasError = true;
        }
    });

    if(hasError) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error en el formulario',
            text: 'Por favor, corrige los errores en el formulario.'
        });
    }
});

</script>
@endsection
