@extends('layouts.app')

@section('content')
<h1>Editar Etiqueta</h1>

@if($errors->any())
  <div class="alert alert-danger" style="display: none;" id="serverErrors">
    <ul>
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.etiquetas.update', $etiqueta->id) }}" method="POST" id="editEtiquetaForm">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $etiqueta->nombre) }}"  onblur="validateNombre()">
        <small id="nombreError" class="text-danger">@error('nombre') {{ $message }} @enderror</small>
    </div>
    <div class="form-group">
        <label for="color">Color (ej: #FF0000)</label>
        <input type="text" name="color" id="color" class="form-control" value="{{ old('color', $etiqueta->color) }}"  onblur="validateColor()">
        <small id="colorError" class="text-danger">@error('color') {{ $message }} @enderror</small>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection

@section('scripts')
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function validateNombre() {
    var nombre = document.getElementById('nombre').value.trim();
    if(nombre === ""){
       document.getElementById('nombreError').textContent = "El nombre es obligatorio.";
    } else {
       document.getElementById('nombreError').textContent = "";
    }
}

function validateColor() {
    var color = document.getElementById('color').value.trim();
    if(color === ""){
       document.getElementById('colorError').textContent = "El color es obligatorio.";
    } else if(!/^#[0-9A-Fa-f]{6}$/.test(color)){
       document.getElementById('colorError').textContent = "El formato de color debe ser #RRGGBB.";
    } else {
       document.getElementById('colorError').textContent = "";
    }
}

document.getElementById('editEtiquetaForm').addEventListener('submit', function(e) {
    // Ejecutamos las validaciones onblur para actualizar los mensajes
    validateNombre();
    validateColor();

    // Verificamos si hay algún error en los mensajes de <small>
    var errorElements = document.querySelectorAll('small.text-danger');
    var hasError = false;
    errorElements.forEach(function(el) {
        if(el.textContent.trim() !== ""){
            hasError = true;
        }
    });
    if(hasError){
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
