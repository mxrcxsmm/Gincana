<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LugarController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\PuntoControlController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\GimcanaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return redirect('/login');
});

Route::get('/inicio', function () {
    return view('inicio');
})->middleware('auth')->name('inicio');

Route::middleware(['auth'])->group(function () {
    Route::get('inicio', [UserController::class, 'index'])->name('inicio');
    Route::get('/api/users', [UserController::class, 'getUsers']);
    Route::get('/api/grupos', [UserController::class, 'getGrupos']);
    Route::post('/api/grupos/join', [UserController::class, 'joinGrupo']);
});

// Grupo de rutas para administración
// Asumiendo que tienes un middleware "auth" y/o un middleware de rol "admin" configurado
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    
    // CRUD de Lugares
    Route::resource('lugares', LugarController::class);

    // CRUD de Etiquetas
    Route::resource('etiquetas', EtiquetaController::class);

    // CRUD de Puntos de Control
    Route::resource('puntos-control', PuntoControlController::class);

    // CRUD de Gimcanas
    Route::resource('gimcanas', GimcanaController::class);
});

// Ruta pública (o interna) para mostrar el mapa con todos los lugares
Route::get('/map', [LugarController::class, 'map'])->name('map');

// Endpoint para devolver los lugares en formato JSON (filtrado por etiqueta y/o favorito)
Route::get('/lugares/json', [LugarController::class, 'json'])->name('lugares.json');

// Ejemplo de toggle de favorito (marcar/desmarcar) para un lugar
Route::post('/lugares/{lugar}/favorito', [FavoritoController::class, 'toggle'])
     ->name('lugares.favorito')
     ->middleware('auth');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// API para lugares
Route::get('/api/lugares', [LugarController::class, 'index']);
Route::get('/api/lugares/buscar', [LugarController::class, 'buscar']);