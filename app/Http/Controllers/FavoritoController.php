<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use App\Models\Lugar;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    /**
     * Marca o desmarca un lugar como favorito para el usuario actual.
     */
    public function toggle(Request $request, Lugar $lugar)
    {
        $usuario = $request->user();

        // Buscamos si ya existe un favorito para este lugar
        $existe = Favorito::where('usuario_id', $usuario->id)
                          ->where('lugar_id', $lugar->id)
                          ->first();

        if ($existe) {
            // Si existe, lo eliminamos (desmarcamos)
            $existe->delete();
            return response()->json([
                'status'  => 'removed',
                'message' => 'El lugar se ha quitado de favoritos'
            ]);
        } else {
            // Si no existe, creamos uno nuevo
            Favorito::create([
                'nombre_etiqueta' => 'Favorito', // o lo que quieras guardar
                'usuario_id'      => $usuario->id,
                'lugar_id'        => $lugar->id
            ]);
            return response()->json([
                'status'  => 'added',
                'message' => 'El lugar se ha agregado a favoritos'
            ]);
        }
    }
}
