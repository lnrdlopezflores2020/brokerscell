<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ReportesController extends Controller
{
    public function GenerarPDF(){
        $clientes = DB::table("cliente");
        $fila = $clientes ->get();
        $pdf = PDF::loadView('cpanel/reportes/pdfClientes', ['data' => $fila]);
        return $pdf->stream('ReporteClientes.pdf');

    }

    public function generarNota($id)
    {
        $reparacion = \App\Models\Reparacion::with('dispositivo.cliente')->findOrFail($id);

        $pdf = \PDF::loadView('cpanel/reportes/NotaReparacion', compact('reparacion'));

        // FORZAR TAMAÑO CARTA (Letter) PARA QUE QUEPA TODO BIEN
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Nota_Servicio_' . $id . '.pdf');
    }

    public function generarNotaEntrega($id)
    {
        $reparacion = Reparacion::with('dispositivo.cliente')->findOrFail($id);

        // Solo permitimos descargar si está terminado o entregado
        if (!in_array($reparacion->est_reparacion, ['Terminado', 'Entregado'])) {
            return redirect()->back()->with('error', 'El equipo aún no está listo.');
        }

        $pdf = PDF::loadView('cpanel/reportes/NotaEntrega', compact('reparacion'));
        return $pdf->stream('Nota_Entrega_' . $id . '.pdf');
    }

    public function GenerarHistorial(){
        $clientes = DB::table("reparacion");
        $fila = $clientes ->get();
        $pdf = PDF::loadView('cpanel/reportes/Reparaciones', ['data' => $fila]);
        return $pdf->stream('HistorialReparaciones.pdf');

    }
}
