@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Mapa de Lugares</h1>
        <div class="form-inline mb-3">
            <label class="mr-2">Filtrar por Etiqueta:</label>
            <select id="filter-etiqueta" class="form-control mr-3">
                <option value="">Todas</option>
                @foreach($etiquetas as $etiqueta)
                    <option value="{{ $etiqueta->id }}">{{ $etiqueta->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div id="map" style="height: 600px; width: 100%;"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Inicializamos el mapa centrado en Barcelona con un zoom adecuado (por ejemplo, 12)
    let map = L.map('map').setView([41.3851, 2.1734], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Map data © OpenStreetMap contributors'
    }).addTo(map);

    let markersLayer = L.layerGroup().addTo(map);

    function loadLugares(etiquetaId = '') {
        let url = '/lugares/json?';
        if (etiquetaId) {
            url += 'etiqueta=' + etiquetaId;
        }
        fetch(url)
          .then(response => response.json())
          .then(data => {
              markersLayer.clearLayers();
              data.forEach(lugar => {
                  let markerOptions = {};
                  if (lugar.marker) {
                      // Nos aseguramos de que la URL empiece con '/' para usar asset correctamente
                      let markerUrl = lugar.marker.startsWith('/') ? lugar.marker : '/' + lugar.marker;
                      markerOptions.icon = L.icon({
                          iconUrl: markerUrl,
                          iconSize: [32, 32]
                      });
                  }
                  let marker = L.marker([lugar.latitud, lugar.longitud], markerOptions)
                                .bindPopup(`
                                  <b>${lugar.nombre}</b><br>
                                  ${lugar.direccion}
                                `);
                  markersLayer.addLayer(marker);
              });
          })
          .catch(err => console.error(err));
    }

    loadLugares();

    document.getElementById('filter-etiqueta').addEventListener('change', function(){
        let etId = this.value;
        loadLugares(etId);
    });
</script>
@endsection
