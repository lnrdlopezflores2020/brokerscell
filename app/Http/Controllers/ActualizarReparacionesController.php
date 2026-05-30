<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; 
use App\Mail\EstadoReparacionActualizado; 
use App\Mail\ReparacionTerminada; 
use App\Mail\ReparacionEntregada; 
use Twilio\Rest\Client; // IMPORTACIÓN DEL SDK DE TWILIO

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

    $reparacion = Reparacion::with('dispositivo.cliente.usuario')->findOrFail($id);

    $estadoAnterior = $reparacion->est_reparacion;
    $estadoNuevo = $request->input('est_reparacion');

    $reparacion->est_reparacion = $estadoNuevo;
    $reparacion->save();

    // LÓGICA DE NOTIFICACIÓN AUTOMÁTICA
    if ($estadoAnterior !== $estadoNuevo) {
        
        $cliente = optional($reparacion->dispositivo)->cliente;
        $correoCliente = optional(optional($cliente)->usuario)->emai; 
        $telefonoCliente = optional($cliente)->telefono;

        // 1. NOTIFICACIÓN POR CORREO ELECTRÓNICO (Si tiene uno)
        if (!empty($correoCliente)) {
            try {
                switch ($estadoNuevo) {
                    case 'Terminado':
                        $correoEnviar = new ReparacionTerminada($reparacion);
                        break;
                    case 'Entregado':
                        $correoEnviar = new ReparacionEntregada($reparacion);
                        break;
                    default:
                        $correoEnviar = new EstadoReparacionActualizado($reparacion);
                        break;
                }
                Mail::to($correoCliente)->send($correoEnviar);
            } catch (\Exception $e) {
                Log::error('Error al enviar correo de estado: ' . $e->getMessage());
            }
        }

        // 2. NOTIFICACIÓN POR SMS / TWILIO
        // Cambiado a "if" independiente para que también envíe SMS si cuenta con teléfono
        if (!empty($telefonoCliente)) {
            try {
                $sid    = env('TWILIO_SID');
                $token  = env('TWILIO_AUTH_TOKEN');
                $from   = env('TWILIO_NUMBER');
                $twilio = new Client($sid, $token);

                $nombre = $cliente->nombre ?? 'Cliente';
                $modelo = optional($reparacion->dispositivo)->modelo ?? 'Equipo';
                $folio  = str_pad($reparacion->ID_rep, 5, '0', STR_PAD_LEFT);

                // Redacción de mensajes
                switch ($estadoNuevo) {
                    case 'Terminado':
                        $mensaje = "¡Hola {$nombre}! Tu {$modelo} (Folio: #{$folio}) ya está listo para entrega en SoluxMovil. Puedes pasar a recogerlo al taller.";
                        break;
                    case 'Entregado':
                        $mensaje = "¡Hola {$nombre}! Confirmamos la entrega de tu {$modelo} (Folio: #{$folio}). Gracias por tu confianza.";
                        break;
                    case 'En revision':
                        $mensaje = "¡Hola {$nombre}! Tu {$modelo} (Folio: #{$folio}) ha ingresado a revisión técnica.";
                        break;
                    case 'En Reparacion':
                        $mensaje = "¡Hola {$nombre}! Hemos comenzado la reparación de tu {$modelo} (Folio: #{$folio}). Te avisaremos al terminar.";
                        break;
                    default:
                        $mensaje = "SoluxMovil: El estado de tu orden #{$folio} ({$modelo}) cambió a: {$estadoNuevo}.";
                        break;
                }

                // OPTIMIZACIÓN DE NÚMERO: Eliminar espacios, guiones o un +52 que ya exista
                $limpio = preg_replace('/[^0-9]/', '', $telefonoCliente); // Solo dígitos
                if (substr($limpio, 0, 2) === '52') {
                    $limpio = substr($limpio, 2); // Quita el 52 si ya lo traía
                }
                $numeroDestino = '+52' . $limpio;

                $twilio->messages->create(
                    $numeroDestino,
                    [
                        'from' => $from,
                        'body' => $mensaje
                    ]
                );

            } catch (\Exception $e) {
                Log::error('Error al enviar mensaje de Twilio: ' . $e->getMessage());
            }
        }
    }

    return redirect('/tecnico/reparaciones')->with('success', 'Estado actualizado correctamente.');
}
}