@extends('layouts.app')

@section('title', 'Crear Gimcana')

@section('content')
    <h1>Crear Gimcana</h1>

    @if($errors->any())
      <div class="alert alert-danger" style="display: none;" id="serverErrors">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('admin.gimcanas.store') }}" method="POST" id="createGimcanaForm">
        @csrf
        <div class="form-group">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}"  onblur="validateNombre()">
            <small id="nombreError" class="text-danger">@error('nombre') {{ $message }} @enderror</small>
        </div>
        <div class="form-group">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"  onblur="validateDescripcion()">{{ old('descripcion') }}</textarea>
            <small id="descripcionError" class="text-danger">@error('descripcion') {{ $message }} @enderror</small>
        </div>
        <div class="form-group">
            <label for="puntos_control">Selecciona Puntos de Control:</label>
            <select name="puntos_control[]" id="puntos_control" class="form-control" multiple  onchange="validatePuntosControl()">
                @foreach($puntos as $punto)
                    <option value="{{ $punto->id }}">
                        {{ $punto->lugar ? $punto->lugar->nombre : 'Lugar desconocido' }}
                    </option>
                @endforeach
            </select>
            <small id="puntosControlError" class="text-danger">@error('puntos_control') {{ $message }} @enderror</small>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.gimcanas.index') }}" class="btn btn-secondary">Volver</a>
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

function validateDescripcion() {
    var descripcion = document.getElementById('descripcion').value.trim();
    if(descripcion === ""){
       document.getElementById('descripcionError').textContent = "La descripción es obligatoria.";
    } else {
       document.getElementById('descripcionError').textContent = "";
    }
}

// Validar que se seleccione al menos 4 puntos de control
function validatePuntosControl() {
    var select = document.getElementById('puntos_control');
    if(select.selectedOptions.length < 4) {
       document.getElementById('puntosControlError').textContent = "Debes seleccionar al menos 4 puntos de control.";
    } else {
       document.getElementById('puntosControlError').textContent = "";
    }
}

document.getElementById('createGimcanaForm').addEventListener('submit', function(e) {
    validateNombre();
    validateDescripcion();
    validatePuntosControl();

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
