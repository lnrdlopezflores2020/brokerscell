<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Dispositivo;
use App\Models\Reparacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

        // Obtenemos el nombre del usuario logueado (sea Admin o Técnico)
        $quienRegistra = auth()->user()->name;

        // Guardamos la descripción original
        $reparacion->descripcion = $request->descripcion;
        $reparacion->fec_inicio = $request->fec_inicio;
        $reparacion->fec_est_entrega = $request->fec_est_entrega;
        $reparacion->est_reparacion = $request->est_reparacion;
        $reparacion->costo = $request->costo;

        $reparacion->save();

        // 3. Redirección dinámica (si es admin lo manda a su vista, si es técnico a la suya)
        $rol = Auth::user()->rol_usuario;
        $rutaRedireccion = $rol === 'administrador' ? '/admon/reparaciones' : '/tecnico/reparaciones';

        return redirect($rutaRedireccion)->with('success', 'Reparación registrada correctamente.');
    }

    // 4. MUESTRA EL HISTORIAL DETALLADO (CORREGIDO)
    public function show($id)
    {
        $rol = Auth::user()->rol_usuario;

        // Validamos correctamente: Si no es ni admin ni técnico, lo sacamos.
        if ($rol !== 'administrador' && $rol !== 'tecnico') {
            return redirect()->back()->with('error', 'No tienes permisos para ver el historial detallado.');
        }

        $reparacion = Reparacion::with(['dispositivo.cliente'])->findOrFail($id);
        
        return view('cpanel/reparaciones/showadmon', compact('reparacion'));
    }

    /**
     * Muestra el formulario de edición (Admin y Técnico)
     */
    public function edit($id)
    {
        $reparacion = Reparacion::findOrFail($id);
        $rol = Auth::user()->rol_usuario;

        if ($rol === 'administrador') {
            return view('cpanel/reparaciones/editrepadmon', compact('reparacion'));
        } elseif ($rol === 'tecnico') {
            return view('tecnico.reparaciones.edit', compact('reparacion'));
        }

        return redirect()->back()->with('error', 'Acceso denegado.');
    }

    /**
     * Actualiza el registro en la base de datos
     */
    public function update(Request $request, $id)
    {
        $reparacion = Reparacion::findOrFail($id);
        $rol = Auth::user()->rol_usuario;

        // Validaciones dinámicas dependiendo de quién edita
        if ($rol === 'administrador') {
            // El admin puede editar todo para corregir errores
            $request->validate([
                'descripcion' => 'required|string',
                'est_reparacion' => 'required|string',
                'costo' => 'required|numeric|min:0',
                'fec_est_entrega' => 'required|date'
            ]);

            $reparacion->descripcion = $request->descripcion;
            $reparacion->costo = $request->costo;
            $reparacion->fec_est_entrega = $request->fec_est_entrega;
        } 
        
        // Todos pueden actualizar el estado
        $request->validate([
            'est_reparacion' => 'required|string'
        ]);
        
        $reparacion->est_reparacion = $request->est_reparacion;
        $reparacion->save();

        $rutaRedireccion = $rol === 'administrador' ? '/admon/reparaciones' : '/tecnico/reparaciones';
        return redirect($rutaRedireccion)->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Elimina el registro de la base de datos (Solo Admin)
     */
    public function destroy($id)
    {
        if (Auth::user()->rol_usuario !== 'administrador') {
            return redirect()->back()->with('error', 'Operación bloqueada. Solo los administradores pueden eliminar registros del historial.');
        }

        $reparacion = Reparacion::findOrFail($id);
        $reparacion->delete();

        return redirect('/admon/reparaciones')->with('success', 'Registro eliminado del historial de forma permanente.');
    }
}