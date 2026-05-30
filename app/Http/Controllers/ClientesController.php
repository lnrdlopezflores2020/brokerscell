<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cliente;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidaClienteMail;
use Illuminate\Database\QueryException; // IMPORTACIÓN NECESARIA PARA ERRORES BD
use Exception;

class ClientesController extends Controller
{
    public function index(){
        $clientes = DB::table('cliente');
        $fila = $clientes->get();
        $data = Cliente::with('usuario')->paginate(10);

        return view('cpanel/clientes/indexclientes',compact('data'), ['data' => $fila]);
    }

    public function create()
    {
        $usuariosClientes = User::where('rol_usuario', 'cliente')
            ->orWhere('rol_usuario', 'Cliente')
            ->select('ID_usuario', 'emai') 
            ->get();

        $fila = new \stdClass();

        return view('cpanel/clientes/createclientes', compact('usuariosClientes', 'fila'));
    }

    public function store(Request $request)
{
    // 1. Verificación de duplicidad por datos personales y teléfono
    $existe = DB::table('cliente')
        ->where('nombre', $request->input('nombre'))
        ->where('apellido', $request->input('apellido'))
        ->where('amat', $request->input('amat'))
        ->where('telefono', $request->input('telefono'))
        ->exists();

    if ($existe) {
        return back()->withInput()->with('error', 'Error: Este cliente ya existe en el sistema con ese nombre y teléfono.');
    }

    // 2. Validación de usuario único (si aplica)
    $Usuario = $request->input('usuario_fk');
    if ($Usuario) {
        $usuarioOcupado = DB::table('cliente')->where('usuario_fk', $Usuario)->exists();
        if ($usuarioOcupado) {
            return back()->withInput()->with('error', 'Error: La cuenta de usuario seleccionada ya tiene un cliente asignado.');
        }
    }

    try {
        DB::table('cliente')->insert([
            'nombre'     => $request->input('nombre'),
            'apellido'   => $request->input('apellido'),
            'amat'       => $request->input('amat'),
            'telefono'   => $request->input('telefono'),
            'direccion'  => $request->input('direccion'),
            'num_ext'    => $request->input('num_ext'),
            'num_int'    => $request->input('num_int'),
            'localidad'  => $request->input('localidad'),
            'estado'     => $request->input('estado'),    
            'usuario_fk' => $Usuario,
        ]);
        
        // ... (código de envío de correo y redirección igual)
    } catch (QueryException $e) {
        return back()->withInput()->with('error', 'Error en la base de datos.');
    }
}

    public function destroy($id){
        try {
            DB::table('cliente')->where('ID_client', '=', $id)->delete();

            if (auth()->user()->rol_usuario === 'administrador') {
                return redirect('/admon/clientes')->with('success', 'Cliente eliminado correctamente.');
            } else {
                return redirect('/tecnico/clientes')->with('success', 'Cliente eliminado correctamente.');
            }
        } catch (QueryException $e) {
            // Error 1451: Intentar eliminar un cliente que ya tiene reparaciones asociadas
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'No se puede eliminar este cliente porque tiene dispositivos o reparaciones en el historial.');
            }
            return back()->with('error', 'Error al intentar eliminar el registro.');
        }
    }

    public function edit($id){
        $fila = DB::table('cliente')->where('ID_client', '=', $id)->first();

        $usuariosClientes = User::where('rol_usuario', 'cliente')
            ->orWhere('rol_usuario', 'Cliente')
            ->select('ID_usuario', 'emai')
            ->get();

        return view('cpanel/clientes/editclientes', compact('fila', 'usuariosClientes'));
    }

    public function update(Request $request, $id)
{
    // 1. Verificación de duplicidad excluyendo el registro actual
    $existe = DB::table('cliente')
        ->where('ID_client', '!=', $id) // NO comparar contra sí mismo
        ->where('nombre', $request->input('nombre'))
        ->where('apellido', $request->input('apellido'))
        ->where('amat', $request->input('amat'))
        ->where('telefono', $request->input('telefono'))
        ->exists();

    if ($existe) {
        return back()->withInput()->with('error', 'Error: Ya existe otro cliente registrado con esos mismos datos.');
    }

    try {
        DB::table('cliente')->where('ID_client', $id)->update([
            'nombre'     => $request->input('nombre'),
            'apellido'   => $request->input('apellido'),
            'amat'       => $request->input('amat'),
            'telefono'   => $request->input('telefono'),
            'direccion'  => $request->input('direccion'),
            'num_ext'    => $request->input('num_ext'),
            'num_int'    => $request->input('num_int'),
            'localidad'  => $request->input('localidad'),
            'estado'     => $request->input('estado'),    
            'usuario_fk' => $request->input('usuario_fk')
        ]);

        // ... (redirección)
    } catch (QueryException $e) {
        return back()->withInput()->with('error', 'Ocurrió un error al actualizar.');
    }
}

    public function exportarExcel()
    {
        return Excel::download(new ClientesExport, 'Reporte_Solo_Clientes.xlsx');
    }
}