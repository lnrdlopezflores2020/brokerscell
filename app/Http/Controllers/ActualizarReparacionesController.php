<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Importación correcta del Log
use App\Mail\EstadoReparacionActualizado; 
use App\Mail\ReparacionTerminada; // IMPORTANTE: Agregar esta línea
use App\Mail\ReparacionEntregada; // IMPORTANTE: Agregar esta línea

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

        // Cargamos la reparación con toda la cadena de relaciones
        $reparacion = Reparacion::with('dispositivo.cliente.usuario')->findOrFail($id);

        $estadoAnterior = $reparacion->est_reparacion;
        $estadoNuevo = $request->input('est_reparacion');

        $reparacion->est_reparacion = $estadoNuevo;
        $reparacion->save();

        // LÓGICA DE NOTIFICACIÓN
        if ($estadoAnterior !== $estadoNuevo) {
            
            $correoCliente = optional(optional($reparacion->dispositivo->cliente)->usuario)->emai; 

            if (!empty($correoCliente)) {
                try {
                    // Seleccionamos el correo dinámicamente según el nuevo estado
                    switch ($estadoNuevo) {
                        case 'Terminado':
                            $correoEnviar = new ReparacionTerminada($reparacion);
                            break;
                            
                        case 'Entregado':
                            $correoEnviar = new ReparacionEntregada($reparacion);
                            break;
                            
                        default:
                            // Para estados como 'En revision' o 'En Reparacion'
                            $correoEnviar = new EstadoReparacionActualizado($reparacion);
                            break;
                    }

                    // Enviamos el correo seleccionado
                    Mail::to($correoCliente)->send($correoEnviar);
                    
                } catch (\Exception $e) {
                    // Evitamos que la app se caiga si falla el envío
                    Log::error('Error al enviar correo de estado: ' . $e->getMessage());
                }
            }
        }

        return redirect('/tecnico/reparaciones')->with('success', 'Estado actualizado y cliente notificado.');
    }
}