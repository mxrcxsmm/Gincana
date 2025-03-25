<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar que el usuario esté autenticado y tenga rol de admin (role_id = 1)
        if (Auth::check() && Auth::user()->role_id === 1) {
            return $next($request);
        }

        abort(403, 'Acceso denegado. No tienes permiso para acceder a esta sección.');
    }
}
