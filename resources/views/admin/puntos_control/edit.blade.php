@extends('layouts.app')

@section('content')
<h1>Editar Punto de Control</h1>

@if($errors->any())
  <div class="alert alert-danger" style="display: none;" id="serverErrors">
    <ul>
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form action="{{ route('admin.puntos-control.update', $puntos_control->id) }}" method="POST" id="editPuntoControlForm">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="lugar_id">Lugar:</label>
        <select name="lugar_id" id="lugar_id" class="form-control"  onchange="validateLugar()">
            <option value="">-- Selecciona un lugar --</option>
            @foreach($lugares as $lugar)
            <option value="{{ $lugar->id }}" {{ $lugar->id == $puntos_control->lugar_id ? 'selected' : '' }}>
                {{ $lugar->nombre }}
            </option>
            @endforeach
        </select>
        <small id="lugarError" class="text-danger">@error('lugar_id') {{ $message }} @enderror</small>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="2"  onblur="validateDescripcion()">{{ old('descripcion', $puntos_control->descripcion) }}</textarea>
        <small id="descripcionError" class="text-danger">@error('descripcion') {{ $message }} @enderror</small>
    </div>
    <div class="form-group">
        <label for="pista">Pista:</label>
        <textarea name="pista" id="pista" class="form-control" rows="2"  onblur="validatePista()">{{ old('pista', $puntos_control->pista) }}</textarea>
        <small id="pistaError" class="text-danger">@error('pista') {{ $message }} @enderror</small>
    </div>
    <div class="form-group">
        <label for="prueba">Prueba:</label>
        <textarea name="prueba" id="prueba" class="form-control" rows="2"  onblur="validatePrueba()">{{ old('prueba', $puntos_control->prueba) }}</textarea>
        <small id="pruebaError" class="text-danger">@error('prueba') {{ $message }} @enderror</small>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>
@endsection

@section('scripts')
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function validateLugar() {
    var lugar = document.getElementById('lugar_id').value;
    if(lugar === ""){
       document.getElementById('lugarError').textContent = "Debes seleccionar un lugar.";
    } else {
       document.getElementById('lugarError').textContent = "";
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

function validatePista() {
    var pista = document.getElementById('pista').value.trim();
    if(pista === ""){
       document.getElementById('pistaError').textContent = "La pista es obligatoria.";
    } else {
       document.getElementById('pistaError').textContent = "";
    }
}

function validatePrueba() {
    var prueba = document.getElementById('prueba').value.trim();
    if(prueba === ""){
       document.getElementById('pruebaError').textContent = "La prueba es obligatoria.";
    } else {
       document.getElementById('pruebaError').textContent = "";
    }
}

document.getElementById('editPuntoControlForm').addEventListener('submit', function(e) {
    validateLugar();
    validateDescripcion();
    validatePista();
    validatePrueba();

    // Verificamos si algún <small> contiene texto (error)
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
