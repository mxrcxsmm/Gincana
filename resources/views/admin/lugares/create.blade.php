@extends('layouts.app')

@section('content')
<h1>Crear Lugar</h1>

@if($errors->any())
    <div class="alert alert-danger" style="display: none;" id="serverErrors">
        <ul>
          @foreach($errors->all() as $error)
             <li>{{ $error }}</li>
          @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.lugares.store') }}" method="POST" enctype="multipart/form-data" id="createLugarForm">
    @csrf
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}"  onblur="validateNombre()">
        <small class="text-danger" id="nombreError">@error('nombre') {{ $message }} @enderror</small>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3"  onblur="validateDescripcion()">{{ old('descripcion') }}</textarea>
        <small class="text-danger" id="descripcionError">@error('descripcion') {{ $message }} @enderror</small>
    </div>

    <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}"  onblur="validateDireccion()">
        <small class="text-danger" id="direccionError">@error('direccion') {{ $message }} @enderror</small>
        <button type="button" class="btn btn-info mt-2" id="btn-geocode">Obtener coordenadas</button>
    </div>

    <div class="form-group">
        <label for="latitud">Latitud:</label>
        <input type="text" name="latitud" id="latitud" class="form-control" value="{{ old('latitud') }}"  onblur="validateLatitud()">
        <small class="text-danger" id="latitudError">@error('latitud') {{ $message }} @enderror</small>
    </div>

    <div class="form-group">
        <label for="longitud">Longitud:</label>
        <input type="text" name="longitud" id="longitud" class="form-control" value="{{ old('longitud') }}"  onblur="validateLongitud()">
        <small class="text-danger" id="longitudError">@error('longitud') {{ $message }} @enderror</small>
    </div>

    <div class="form-group">
        <label for="marker">Icono (marker):</label>
        <input type="file" name="marker" id="marker" class="form-control-file" onchange="validateMarker()">
        <small class="text-danger" id="markerError">@error('marker') {{ $message }} @enderror</small>
    </div>

    <div class="form-group">
        <label for="etiquetas">Etiquetas:</label>
        <select name="etiquetas[]" id="etiquetas" class="form-control" multiple onchange="validateEtiquetas()">
            @foreach($etiquetas as $etiqueta)
            <option value="{{ $etiqueta->id }}">{{ $etiqueta->nombre }}</option>
            @endforeach
        </select>
        <small class="text-danger" id="etiquetasError">@error('etiquetas') {{ $message }} @enderror</small>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
</br>
@endsection

@section('scripts')
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Geocodificación con Nominatim (OpenStreetMap)
document.getElementById('btn-geocode').addEventListener('click', function(){
    var direccion = document.getElementById('direccion').value;
    if(!direccion) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Ingresa una dirección.'
        });
        return;
    }
    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(direccion))
      .then(response => response.json())
      .then(data => {
          if(data.length > 0) {
              document.getElementById('latitud').value = data[0].lat;
              document.getElementById('longitud').value = data[0].lon;
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'No encontrado',
                  text: 'No se encontraron resultados de geocodificación.'
              });
          }
      })
      .catch(err => {
          console.error(err);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error al geocodificar la dirección.'
          });
      });
});

// Funciones de validación onblur

function validateNombre() {
    var nombre = document.getElementById('nombre').value.trim();
    if(nombre === "") {
        document.getElementById('nombreError').textContent = "El nombre es obligatorio.";
    } else {
        document.getElementById('nombreError').textContent = "";
    }
}

function validateDescripcion() {
    var descripcion = document.getElementById('descripcion').value.trim();
    if(descripcion === "") {
        document.getElementById('descripcionError').textContent = "La descripción es obligatoria.";
    } else {
        document.getElementById('descripcionError').textContent = "";
    }
}

function validateDireccion() {
    var direccion = document.getElementById('direccion').value.trim();
    if(direccion === "") {
        document.getElementById('direccionError').textContent = "La dirección es obligatoria.";
    } else {
        document.getElementById('direccionError').textContent = "";
    }
}

function validateLatitud() {
    var latitud = document.getElementById('latitud').value.trim();
    if(latitud === "" || isNaN(latitud)) {
        document.getElementById('latitudError').textContent = "La latitud debe ser un número válido.";
    } else {
        document.getElementById('latitudError').textContent = "";
    }
}

function validateLongitud() {
    var longitud = document.getElementById('longitud').value.trim();
    if(longitud === "" || isNaN(longitud)) {
        document.getElementById('longitudError').textContent = "La longitud debe ser un número válido.";
    } else {
        document.getElementById('longitudError').textContent = "";
    }
}

function validateMarker() {
    var markerInput = document.getElementById('marker');
    if(markerInput.files.length === 0) {
        document.getElementById('markerError').textContent = "Debes subir un icono.";
    } else {
        document.getElementById('markerError').textContent = "";
    }
}

function validateEtiquetas() {
    var etiquetas = document.getElementById('etiquetas').selectedOptions;
    if(etiquetas.length === 0) {
        document.getElementById('etiquetasError').textContent = "Debes seleccionar al menos una etiqueta.";
    } else {
        document.getElementById('etiquetasError').textContent = "";
    }
}

// Validación final al enviar el formulario
document.getElementById('createLugarForm').addEventListener('submit', function(e) {
    // Ejecutamos todas las validaciones
    validateNombre();
    validateDescripcion();
    validateDireccion();
    validateLatitud();
    validateLongitud();
    validateMarker();
    validateEtiquetas();

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
