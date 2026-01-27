<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Si no está logueado, fuera.
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 2. Verificar si el rol del usuario está en la lista de permitidos
        // Importante: Esto compara lo que hay en tu BD (ej: "Administrador")
        // con lo que pones en la ruta.
        if (in_array($user->rol_usuario, $roles)) {
            return $next($request);
        }

        // 3. Si no tiene permiso, error 403 (Prohibido)
        abort(403, 'No tienes permiso para acceder a esta sección.');
    }
}
