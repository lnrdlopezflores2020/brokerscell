<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultasController extends Controller
{
    public function index()
    {
        // 1. En lugar del email, obtenemos el ID del usuario logueado
        $idUsuario = auth()->id();

        // 2. Buscamos las reparaciones donde el cliente tenga ese 'usuario_fk'
        $reparaciones = Reparacion::whereHas('dispositivo.cliente', function($query) use ($idUsuario) {
            // Comparamos la llave foránea con el ID del usuario conectado
            $query->where('usuario_fk', $idUsuario);
        })->orderBy('ID_rep', 'desc')->get();

        return view('cpanel/reparaciones/indexConsulta', compact('reparaciones'));
    }
}
