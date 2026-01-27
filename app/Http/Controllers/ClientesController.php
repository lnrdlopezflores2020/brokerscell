<?php
namespace App\Http\Controllers;
use App\Exports\ClientesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cliente;
use Maatwebsite\Excel\Facades\Excel;

class ClientesController extends Controller
{
    public function index(){
        $clientes = DB::table('cliente');
        $fila = $clientes->get();
        $data = Cliente::with('usuario')->get();

        return view('cpanel/clientes/indexclientes',compact('data'), ['data' => $fila]);
    }

    public function create()
    {
        // NOTA: Asegúrate que en tu BD el rol sea 'cliente' o 'Cliente'
        $usuariosClientes = User::where('rol_usuario', 'cliente')
            ->orWhere('rol_usuario', 'Cliente')
            ->select('ID_usuario', 'emai') // Si cambiaste emai a email en BD, ajusta aquí
            ->get();

        // Enviamos un objeto vacío para que el formulario no falle al intentar leer propiedades
        $fila = new \stdClass();

        return view('cpanel/clientes/createclientes', compact('usuariosClientes', 'fila'));
    }

    public function store(Request $request){
        // 1. Recibimos el ID del usuario
        $Usuario = $request->input('usuario_fk');

        // --- VALIDACIÓN DE DUPLICADOS ---
        // Verificamos si ya existe ese usuario asociado
        $existe = DB::table('cliente')
            ->where('usuario_fk', $Usuario)
            ->exists();

        if ($existe) {
            // CORRECCIÓN IMPORTANTE:
            // Usamos back() para volver al formulario.
            // Usamos withInput() para recuperar los datos escritos (nombre, apellido, etc).
            return back()
                ->withInput()
                ->with('error', 'Error: El usuario seleccionado ya tiene un cliente asignado.');
        }
        // ---------------------------------

        // 2. Insertamos en la Base de Datos
        // Nota: Si usas DB::table, los campos 'created_at' y 'updated_at' no se llenan solos.
        // Si los necesitas, agrega: 'created_at' => now(),
        DB::table('cliente')->insert([
            'nombre'     => $request->input('nombre'),
            'apellido'   => $request->input('apellido'),
            'telefono'   => $request->input('telefono'),
            'direccion'  => $request->input('direccion'),
            'num_ext'    => $request->input('num_ext'),
            'num_int'    => $request->input('num_int'),
            'usuario_fk' => $Usuario,
            // 'created_at' => now(), // Descomenta esto si tu tabla usa timestamps
            // 'updated_at' => now(),
        ]);

        // 3. REDIRECCIÓN SEGURA (Tal como la definiste, está perfecta)
        if (auth()->user()->rol_usuario === 'administrador') {
            return redirect('/admon/clientes')->with('success', 'Cliente guardado correctamente.');
        } else {
            return redirect('/tecnico/clientes')->with('success', 'Cliente guardado correctamente.');
        }
    }

    public function destroy($id){
        DB::table('cliente')->where('ID_client', '=', $id)->delete();

        if (auth()->user()->rol_usuario === 'administrador') {
            return redirect('/admon/clientes')->with('success', 'Cliente eliminado correctamente.');
        } else {
            return redirect('/tecnico/clientes')->with('success', 'Cliente eliminado correctamente.');
        }
    }

    public function edit($id){
        // Mantenemos tu estructura DB::table
        $fila = DB::table('cliente')->where('ID_client', '=', $id)->first();

        $usuariosClientes = User::where('rol_usuario', 'cliente')
            ->orWhere('rol_usuario', 'Cliente')
            ->select('ID_usuario', 'emai')
            ->get();

        return view('cpanel/clientes/editclientes', compact('fila', 'usuariosClientes'));
    }

    public function update(Request $request, $id){
        // Obtenemos todos los datos del formulario HTML
        $datosUsuario = request()->except(['_token','_method']);

        // Actualizamos mapeando: Columna_BD => $datosUsuario['name_del_html']
        DB::table('cliente')->where('ID_client', $id)->update([
            'nombre'     => $datosUsuario['nombre'],
            'apellido'   => $datosUsuario['apellido'],
            'telefono'   => $datosUsuario['telefono'],
            'direccion'  => $datosUsuario['direccion'],
            'num_ext'    => $datosUsuario['num_ext'],    // HTML: name="num_ext"
            'num_int'    => $datosUsuario['num_int'],    // HTML: name="num_int"
            'usuario_fk' => $datosUsuario['usuario_fk']  // HTML: name="usuario_fk"
        ]);

        if (auth()->user()->rol_usuario === 'administrador') {
            return redirect('/admon/clientes')->with('success', 'Información actualizada correctamente.');
        } else {
            return redirect('/tecnico/clientes')->with('success', 'Información actualizada correctamente.');
        }
    }

    public function exportarExcel()
    {
        // El segundo parámetro es el nombre del archivo que se descargará
        return Excel::download(new ClientesExport, 'Reporte_Solo_Clientes.xlsx');
    }
}
