<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException; // IMPORTACIÓN PARA MANEJAR ERRORES DE BD

class DispositivosController extends Controller
{
    public function index(){
        $dispositivos = DB::table('dispositivo');
        $fila = $dispositivos->paginate(10);

        return view('cpanel/dispositivos/indexdispositivos',  ['data' => $fila]);
    }

    public function create(){
        $clientes = DB::table('cliente')
            ->select('ID_client', 'nombre', 'apellido')
            ->orderBy('nombre', 'asc') // Ordenarlos alfabéticamente ayuda a buscar rápido
            ->get();

        return view('cpanel/dispositivos/createdispositivos', compact('clientes'));
    }

    // Guardar el dispositivo en la BD
   public function store(Request $request)
{
    $request->validate([
        'tipo' => 'required|string|max:30',
        'marca' => 'required|string|max:20',
        'modelo' => 'required|string|max:20',
        'id_client_fk' => 'required|exists:cliente,ID_client',
    ]);

    // Verificar si ya existe un dispositivo igual para este cliente
    $existe = DB::table('dispositivo')
        ->where('id_client_fk', $request->input('id_client_fk'))
        ->where('tipo', $request->input('tipo'))
        ->where('marca', $request->input('marca'))
        ->where('modelo', $request->input('modelo'))
        ->exists();

    if ($existe) {
        return back()->withInput()->with('error', 'Error: Este cliente ya tiene registrado un dispositivo con esas mismas características.');
    }

    try {
        DB::table('dispositivo')->insert([
            'tipo' => $request->input('tipo'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'id_client_fk' => $request->input('id_client_fk')
        ]);

        return redirect()->route('dispositivos.index')->with('success', 'Dispositivo registrado correctamente.');
    } catch (QueryException $e) {
        return back()->withInput()->with('error', 'Ocurrió un error al guardar en la base de datos.');
    }
}

    public function edit($id)
    {
        // 1. Buscamos el dispositivo por su ID
        $dispositivo = DB::table('dispositivo')->where('ID_tel', $id)->first();

        // 2. Necesitamos la lista de clientes para llenar el <select>
        $clientes = DB::table('cliente')
            ->select('ID_client', 'nombre', 'apellido')
            ->orderBy('nombre', 'asc')
            ->get();

        // 3. Retornamos la vista pasando ambas variables
        return view('cpanel/dispositivos/editdispositivos', compact('dispositivo', 'clientes'));
    }

    /**
     * Procesa la actualización en la base de datos
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'tipo' => 'required|string|max:30',
        'marca' => 'required|string|max:20',
        'modelo' => 'required|string|max:20',
        'id_client_fk' => 'required|exists:cliente,ID_client',
    ]);

    // Verificar duplicados, pero excluyendo el ID actual para permitir guardar sin cambios
    $existe = DB::table('dispositivo')
        ->where('id_client_fk', $request->input('id_client_fk'))
        ->where('tipo', $request->input('tipo'))
        ->where('marca', $request->input('marca'))
        ->where('modelo', $request->input('modelo'))
        ->where('ID_tel', '!=', $id) // Excluimos el registro actual
        ->exists();

    if ($existe) {
        return back()->withInput()->with('error', 'Error: El cliente ya posee otro dispositivo con esta misma descripción.');
    }

    try {
        DB::table('dispositivo')
            ->where('ID_tel', $id)
            ->update([
                'tipo' => $request->input('tipo'),
                'marca' => $request->input('marca'),
                'modelo' => $request->input('modelo'),
                'id_client_fk' => $request->input('id_client_fk')
            ]);

        return redirect('tecnico/dispositivos')->with('success', 'Dispositivo actualizado correctamente.');
    } catch (QueryException $e) {
        return back()->withInput()->with('error', 'Ocurrió un error al actualizar los datos.');
    }
}
    public function destroy($id){
        try {
            DB::table('dispositivo')->where('ID_tel', '=', $id)->delete();

            return redirect('/tecnico/dispositivos')->with('success', 'Dispositivo eliminado correctamente.');
            
        } catch (QueryException $e) {
            // Error 1451: Intentar eliminar un dispositivo que ya tiene historial de reparaciones
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'No se puede eliminar este dispositivo porque tiene reparaciones asociadas en el historial.');
            }
            return back()->with('error', 'Error al intentar eliminar el dispositivo.');
        }
    }
}