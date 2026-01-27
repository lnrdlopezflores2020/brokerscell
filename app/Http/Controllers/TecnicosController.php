<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // 1. Recibimos los datos con los NUEVOS nombres del HTML
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $telefono = $request->input('telefono');
        $Usuario = $request->input('usuario_fk');

        // 2. Insertamos en la Base de Datos (Nombres de columnas BD se mantienen igual)
        DB::table('tecnico')->insert([
            'nombre'     => $nombre,
            'apellido'   => $apellido,
            'tel_tecnico'   => $telefono,
            'usuario_fk' => $Usuario
        ]);

        return redirect()->route('tecnicos.index')
            ->with('success', 'El cliente se ha guardado correctamente.');
    }

    public function destroy($id){
        DB::table('tecnico')->where('ID_tec', '=', $id)->delete();
        return redirect()->route('tecnicos.index');
    }

    public function edit($id){
        // Mantenemos tu estructura DB::table
        $fila = DB::table('tecnico')->where('ID_tec', '=', $id)->first();

        $usuariosTecnicos = User::where('rol_usuario', 'tecnico')
            ->orWhere('rol_usuario', 'Tecnico')
            ->select('ID_usuario', 'emai')
            ->get();

        return view('cpanel/tecnicos/edittecnicos', compact('fila', 'usuariosTecnicos'));
    }

    public function update(Request $request, $id){
        // Obtenemos todos los datos del formulario HTML
        $datosUsuario = request()->except(['_token','_method']);

        // Actualizamos mapeando: Columna_BD => $datosUsuario['name_del_html']
        DB::table('tecnico')->where('ID_tec', $id)->update([
            'nombre'     => $datosUsuario['nombre'],
            'apellido'   => $datosUsuario['apellido'],
            'tel_tecnico'   => $datosUsuario['telefono'],
            'usuario_fk' => $datosUsuario['usuario_fk']  // HTML: name="usuario_fk"
        ]);

        return redirect()->route('tecnicos.index');
    }

    public function dashboard()
    {
        // 1. Calcular estadísticas para las tarjetas (KPIs)
        // Usamos los nombres EXACTOS de los estados que definiste en tu select
        $stats = [
            // Tarjeta Roja: Solo 'Pendiente'
            'Pendiente' => Reparacion::where('est_reparacion', 'Pendiente')->count(),

            // Tarjeta Amarilla: Sumamos 'En revision' y 'En Reparacion'
            'en_proceso' => Reparacion::whereIn('est_reparacion', ['En revision', 'En Reparacion'])->count(),

            // Tarjeta Verde: 'Terminado' y 'Entregado'
            'terminados' => Reparacion::whereIn('est_reparacion', ['Terminado', 'Entregado'])
                ->whereDate('updated_at', now()) // Solo los de hoy
                ->count()
        ];

        // 2. Obtener la lista de reparaciones para la tabla
        // Hacemos JOIN para traer datos del cliente y dispositivo
        $reparaciones = Reparacion::join('dispositivo', 'reparacion.id_tel_fk', '=', 'dispositivo.ID_tel')
            ->join('cliente', 'dispositivo.id_client_fk', '=', 'cliente.ID_client')
            ->select(
                'reparacion.*',
                'dispositivo.marca', 'dispositivo.modelo', 'dispositivo.tipo',
                'cliente.nombre as cliente_nombre', 'cliente.apellido as cliente_apellido'
            )
            // Ordenamos: Los pendientes primero, luego por fecha
            ->orderByRaw("FIELD(est_reparacion, 'Pendiente', 'En revision', 'En Reparacion', 'Terminado', 'Entregado')")
            ->orderBy('reparacion.fec_inicio', 'desc')
            ->get();

        // 3. Retornar la vista
        // AJUSTA 'cpanel.tecnicos.index' a la ruta real donde guardaste tu archivo blade
        return view('cpanel/Inicios/InicioTecnicos', compact('stats', 'reparaciones'));
    }
    public function updateStatus(Request $request, $id)
    {
        // Validamos que el estado sea uno de los permitidos
        $request->validate([
            'est_reparacion' => 'required|string'
        ]);

        // Actualizamos usando el ID_rep
        DB::table('reparacion')
            ->where('ID_rep', $id)
            ->update([
                'est_reparacion' => $request->input('est_reparacion'),
                // Opcional: Si tienes un campo de "notas técnicas", actualízalo aquí también
                // 'descripcion' => $request->input('nota_tecnica')
            ]);

        return back()->with('success', 'Estado de la reparación #' . $id . ' actualizado.');
    }
}
