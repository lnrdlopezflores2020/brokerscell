<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardClientescoltroller extends Controller
{
    public function index()
    {
        // 1. Obtenemos el ID del usuario conectado (la llave primaria de la tabla usuario)
        $idUsuario = auth()->id();

        // 2. Buscamos las reparaciones donde el cliente tenga ese usuario_fk
        $reparaciones = \App\Models\Reparacion::whereHas('dispositivo.cliente', function($query) use ($idUsuario) {

            // CORRECCIÓN: Usamos 'usuario_fk' que sí existe en tu tabla
            $query->where('usuario_fk', $idUsuario);

        })->with('dispositivo')->orderBy('ID_rep', 'desc')->get();

        // 3. Totales (igual que antes)
        $pendientes = $reparaciones->whereIn('est_reparacion', ['Pendiente', 'En revision', 'En Reparacion'])->count();
        $listos = $reparaciones->whereIn('est_reparacion', ['Terminado', 'Entregado'])->count();
        $totalGastado = $reparaciones->sum('costo');

        return view('cpanel/Inicios/inicioClientes', compact('reparaciones', 'pendientes', 'listos', 'totalGastado'));
    }
}
