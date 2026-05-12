<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TecnicosController extends Controller
{
    public function index(){
        $tecnicos = DB::table('tecnico');
        $fila = $tecnicos->get();
        return view('cpanel/tecnicos/indextecnicos', ['data' => $fila]);
    }

    public function create(){
        $usuariosTecnicos = User::where('rol_usuario', 'tecnico')
            ->orWhere('rol_usuario', 'Tecnico')
            ->select('ID_usuario', 'emai') // Si cambiaste emai a email en BD, ajusta aquí
            ->get();

        $fila = new \stdClass();

        return view('cpanel/tecnicos/createtecnicos', compact('usuariosTecnicos', 'fila'));
    }

    public function store(Request $request){
        // 1. Recibimos los datos
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $telefono = $request->input('telefono');
        $Usuario = $request->input('usuario_fk');

        try {
            // 2. Intentamos insertar en la Base de Datos
            DB::table('tecnico')->insert([
                'nombre'     => $nombre,
                'apellido'   => $apellido,
                'tel_tecnico'=> $telefono,
                'usuario_fk' => $Usuario
            ]);

            return redirect()->route('tecnicos.index')
                ->with('success', 'El técnico se ha guardado correctamente.');

        } catch (QueryException $e) {
            // Manejo de Error de Duplicidad (Código 1062 en MySQL)
            if ($e->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', 'La cuenta de usuario seleccionada o el número de teléfono ya están asignados a otro técnico.');
            }
            // Cualquier otro error de base de datos
            return back()->withInput()->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            DB::table('tecnico')->where('ID_tec', '=', $id)->delete();
            return redirect()->route('tecnicos.index')->with('success', 'Técnico eliminado correctamente.');
        } catch (QueryException $e) {
            // Si intentan eliminar un técnico que ya tiene reparaciones asignadas
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'No se puede eliminar este técnico porque tiene reparaciones asociadas en el historial.');
            }
            return back()->with('error', 'Error al intentar eliminar el técnico.');
        }
    }

    public function edit($id){
        $fila = DB::table('tecnico')->where('ID_tec', '=', $id)->first();

        $usuariosTecnicos = User::where('rol_usuario', 'tecnico')
            ->orWhere('rol_usuario', 'Tecnico')
            ->select('ID_usuario', 'emai')
            ->get();

        return view('cpanel/tecnicos/edittecnicos', compact('fila', 'usuariosTecnicos'));
    }

    public function update(Request $request, $id){
        $datosUsuario = request()->except(['_token','_method']);

        try {
            // Actualizamos en BD
            DB::table('tecnico')->where('ID_tec', $id)->update([
                'nombre'     => $datosUsuario['nombre'],
                'apellido'   => $datosUsuario['apellido'],
                'tel_tecnico'=> $datosUsuario['telefono'],
                'usuario_fk' => $datosUsuario['usuario_fk']  
            ]);

            return redirect()->route('tecnicos.index')->with('success', 'Datos del técnico actualizados correctamente.');

        } catch (QueryException $e) {
            // Manejo de Error de Duplicidad al actualizar
            if ($e->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', 'La cuenta de usuario seleccionada ya está asignada a otro técnico.');
            }
            return back()->withInput()->with('error', 'Ocurrió un error al actualizar los datos.');
        }
    }

    public function dashboard()
    {
        // 1. Calcular estadísticas para las tarjetas (KPIs)
        $stats = [
            'Pendiente' => Reparacion::where('est_reparacion', 'Pendiente')->count(),
            'en_proceso' => Reparacion::whereIn('est_reparacion', ['En revision', 'En Reparacion'])->count(),
            'terminados' => Reparacion::whereIn('est_reparacion', ['Terminado', 'Entregado'])
                ->whereDate('updated_at', now()) // Solo los de hoy
                ->count()
        ];

        // 2. Obtener la lista de reparaciones para la tabla
        $reparaciones = Reparacion::join('dispositivo', 'reparacion.id_tel_fk', '=', 'dispositivo.ID_tel')
            ->join('cliente', 'dispositivo.id_client_fk', '=', 'cliente.ID_client')
            ->select(
                'reparacion.*',
                'dispositivo.marca', 'dispositivo.modelo', 'dispositivo.tipo',
                'cliente.nombre as cliente_nombre', 'cliente.apellido as cliente_apellido'
            )
            ->orderByRaw("FIELD(est_reparacion, 'Pendiente', 'En revision', 'En Reparacion', 'Terminado', 'Entregado')")
            ->orderBy('reparacion.fec_inicio', 'desc')
            ->get();

        return view('cpanel/Inicios/InicioTecnicos', compact('stats', 'reparaciones'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'est_reparacion' => 'required|string'
        ]);

        DB::table('reparacion')
            ->where('ID_rep', $id)
            ->update([
                'est_reparacion' => $request->input('est_reparacion')
            ]);

        return back()->with('success', 'Estado de la reparación #' . str_pad($id, 5, '0', STR_PAD_LEFT) . ' actualizado.');
    }
}