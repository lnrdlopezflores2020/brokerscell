<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Conteos Generales
        $totalClientes = User::where('rol_usuario', 'cliente')->count();
        $totalStaff = User::whereIn('rol_usuario', ['administrador', 'tecnico'])->count();

        // 2. Conteos por Estado
        $pendientes   = Reparacion::where('est_reparacion', 'Pendiente')->count();
        $enRevision   = Reparacion::where('est_reparacion', 'En revision')->count();
        $enReparacion = Reparacion::where('est_reparacion', 'En Reparacion')->count();
        $terminados   = Reparacion::where('est_reparacion', 'Terminado')->count();
        $entregados   = Reparacion::where('est_reparacion', 'Entregado')->count();

        $ingresosTotales = Reparacion::whereIn('est_reparacion', ['Terminado', 'Entregado'])->sum('costo');

        // 3. DATOS PARA GRÁFICA DE TENDENCIA (Por Mes)
        // Esto agrupa las reparaciones del año actual por mes
        $reparacionesPorMes = Reparacion::selectRaw('MONTH(fec_inicio) as mes, COUNT(*) as total')
            ->whereYear('fec_inicio', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        // Rellenar con 0 los meses que no tengan datos (para que el array siempre tenga 12 valores)
        $dataTendencia = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataTendencia[] = $reparacionesPorMes[$i] ?? 0;
        }

        // 4. ÚLTIMOS 5 INGRESOS (Para la tabla de abajo)
        $ultimosIngresos = Reparacion::with(['dispositivo.cliente'])
            ->latest('fec_inicio')
            ->take(5)
            ->get();

        return view('cpanel/Inicios/inicio', compact(
            'totalClientes', 'totalStaff',
            'pendientes', 'enRevision', 'enReparacion', 'terminados', 'entregados',
            'ingresosTotales', 'dataTendencia', 'ultimosIngresos'
        ));
    }
}
