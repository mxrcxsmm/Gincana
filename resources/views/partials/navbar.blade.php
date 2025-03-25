<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Mi App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
       <ul class="navbar-nav">
           <li class="nav-item"><a class="nav-link" href="{{ route('admin.lugares.index') }}">Lugares</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ route('admin.etiquetas.index') }}">Etiquetas</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ route('admin.puntos-control.index') }}">Puntos Control</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ route('admin.gimcanas.index') }}">Gincana</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ route('map') }}">Ver Mapa</a></li>           
           <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="button-logout">Cerrar sesión</button>
        </form>
       </ul>
    </div>
</nav>
