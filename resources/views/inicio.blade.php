<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{asset('css/inicio.css')}}">

    <title>Gimcana</title>   

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Parkinsans:wght@300..800&display=swap" rel="stylesheet">
    <title>Inicio</title>
</head>
<body>
    <div class="hamburger-menu" onclick="toggleMenu()">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="cabezera-container">
        <div class="cabezera">
            <div class="search-container">
                <input type="text" class="search-box" id="searchBox" placeholder="Buscar localizaciones">
            </div>
                <div class="filter-buttons">
                    <button class="filter-button" data-etiqueta="Restaurante">Restaurantes</button>
                    <button class="filter-button" data-etiqueta="Museo">Museos</button>
                    <button class="filter-button" data-etiqueta="Tienda">Tiendas</button>
                    <button class="filter-button" data-etiqueta="Parque">Parques</button>
                    <button class="filter-button" data-etiqueta="Bar">Bares</button>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="button-logout">Cerrar sesión</button>
                </form>
                </div>
        </div>
    </div>

    <div id="map"></div>

    @if(!$grupo)
        <button class="play-button" onclick="openLobby()">Jugar Gincana</button>
        
        <!-- Modal Lobby -->
        <div id="lobbyModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeLobby()">&times;</span>
                <h2>Lobby de Jugadores</h2>
                <div class="users-list" id="usersList">
                    <!-- Los usuarios se cargarán aquí dinámicamente -->
                </div>
            </div>
        </div>
    @else
        <div class="searching-text">
            Buscando... {{ $puntoControl->etiquetas->first()->nombre ?? 'Punto de Control 1' }}
        </div>

        <!-- Modal Pista -->
        <div id="pistaModal" class="modal">
            <div class="modal-content">
                <h2>Pista para el Punto de Control</h2>
                <p>{{ $puntoControl->descripcion ?? 'Busca un lugar con la etiqueta indicada' }}</p>
            </div>
        </div>
    @endif

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('js/mapa.js') }}"></script>
    <script>
        // Configurar CSRF token
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Funciones para el lobby
        function openLobby() {
            document.getElementById('lobbyModal').style.display = 'block';
            loadUsers();
        }

        function closeLobby() {
            document.getElementById('lobbyModal').style.display = 'none';
        }

        async function loadUsers() {
            try {
                const response = await axios.get('/api/users');
                const usersList = document.getElementById('usersList');
                usersList.innerHTML = response.data.map(user => `
                    <div class="user-item">
                        <span>${user.name}</span>
                        <button onclick="inviteUser(${user.id})">Invitar</button>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error cargando usuarios:', error);
            }
        }

        // Si el usuario está en un grupo, mostrar la pista inicial
        @if($grupo)
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('pistaModal').style.display = 'block';
            });
        @endif

        // Función para mostrar/ocultar el menú en dispositivos móviles
        function toggleMenu() {
            const cabezeraContainer = document.querySelector('.cabezera-container');
            cabezeraContainer.classList.toggle('active');
        }
    </script>
</body>
</html>