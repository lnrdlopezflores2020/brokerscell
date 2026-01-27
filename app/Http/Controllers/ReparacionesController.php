<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Dispositivo;
use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparacionesController extends Controller
{
    public function index(){
        $reparaciones = DB::table('reparacion');
        $fila = $reparaciones->get();
        return view('cpanel/reparaciones/indexreparacion',['data' => $fila]);
    }

    public function create()
    {
        // Enviamos todos los clientes para el primer Select
        $clientes = Cliente::all();
        return view('cpanel/reparaciones/createreparaciones', compact('clientes'));
    }

    // 2. DEVUELVE LOS DISPOSITIVOS EN JSON (Para JavaScript)
    public function getDispositivos($id_cliente)
    {
        // Buscamos dispositivos donde id_client_fk coincida
        $dispositivos = Dispositivo::where('id_client_fk', $id_cliente)->get();
        return response()->json($dispositivos);
    }

    // 3. GUARDA LA REPARACIÓN
    public function store(Request $request)
    {
        // 1. Validación (Se mantiene igual)
        $request->validate([
            'id_tel_fk' => 'required|exists:dispositivo,ID_tel',
            'fec_inicio' => 'required|date',
            'fec_est_entrega' => 'required|date|after_or_equal:fec_inicio',
            'descripcion' => 'required',
            'est_reparacion' => 'required'
        ]);

        // 2. Guardar datos
        $reparacion = new Reparacion();
        $reparacion->id_tel_fk = $request->id_tel_fk;

        // --- AQUÍ ESTÁ EL TRUCO DE LA FIRMA ---
        // Obtenemos el nombre del usuario logueado (sea Admin o Técnico)
        $quienRegistra = auth()->user()->name;

        // Guardamos la descripción original MÁS la etiqueta oculta
        // Ejemplo en BD: "Pantalla rota ||TEC:JuanPerez||"
        $reparacion->descripcion = $request->descripcion;

        $reparacion->fec_inicio = $request->fec_inicio;
        $reparacion->fec_est_entrega = $request->fec_est_entrega;
        $reparacion->est_reparacion = $request->est_reparacion;
        $reparacion->costo = $request->costo;

        $reparacion->save();

        // 3. Redirección

        return redirect('/tecnico/reparaciones')->with('success', 'Reparación registrada correctamente.');

    }

    public function destroy($id){
        DB::table('reparacion')->where('ID_rep', '=', $id)->delete();

        return redirect('/tecnico/reparaciones')->with('success', 'Cliente eliminado correctamente.');

    }
}
