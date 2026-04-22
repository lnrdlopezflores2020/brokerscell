<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // IMPORTANTE: Agregar esta línea
use App\Mail\EstadoReparacionActualizado; // IMPORTANTE: Agregar esta línea

class ActualizarReparacionesController extends Controller
{
    public function index(Request $request)
    {
        $query = Reparacion::query();

        if ($request->has('busqueda') && $request->busqueda != '') {
            $query->where('ID_rep', 'LIKE', '%' . $request->busqueda . '%');
        }

        $data = $query->orderBy('ID_rep', 'desc')->get();

        return view('cpanel/reparaciones/indexActRep', compact('data'));
    }

    public function edit($id){
        $reparacion = Reparacion::with('dispositivo.cliente')->findOrFail($id);
        return view('cpanel/reparaciones/editreparacion', compact('reparacion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'est_reparacion' => 'required|string'
        ]);

        // Cargamos la reparación con toda la cadena de relaciones hasta el usuario para sacar su email
        $reparacion = Reparacion::with('dispositivo.cliente.usuario')->findOrFail($id);

        $estadoAnterior = $reparacion->est_reparacion;
        $estadoNuevo = $request->input('est_reparacion');

        $reparacion->est_reparacion = $estadoNuevo;
        $reparacion->save();

        // LÓGICA DE NOTIFICACIÓN: Solo enviar si el estado realmente cambió
        if ($estadoAnterior !== $estadoNuevo) {
            
            // Navegamos por las relaciones de forma segura usando optional() por si algún dato falta
            // Nota: Cambia 'emai' por 'email' si así se llama en tu base de datos
            $correoCliente = optional(optional($reparacion->dispositivo->cliente)->usuario)->emai; 

            if (!empty($correoCliente)) {
                try {
                    Mail::to($correoCliente)->send(new EstadoReparacionActualizado($reparacion));
                } catch (\Exception $e) {
                    // Si falla el correo (por internet o credenciales), no rompemos la app
                    \Log::error($e->getMessage());
                }
            }
        }

        return redirect('/tecnico/reparaciones')->with('success', 'Estado actualizado y cliente notificado.');
    }
}