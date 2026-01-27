<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DispositivosController extends Controller
{
    public function index(){
        $dispositivos = DB::table('dispositivo');
        $fila = $dispositivos->get();

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
        // Validación básica
        $request->validate([
            'tipo' => 'required|string|max:30',
            'marca' => 'required|string|max:20',
            'modelo' => 'required|string|max:20',
            'id_client_fk' => 'required|exists:cliente,ID_client', // Verifica que el cliente exista
        ]);

        // Insertar usando los nombres exactos de tu tabla
        DB::table('dispositivo')->insert([
            'tipo' => $request->input('tipo'),
            'marca' => $request->input('marca'),
            'modelo' => $request->input('modelo'),
            'id_client_fk' => $request->input('id_client_fk') // Aquí guardamos el ID seleccionado
        ]);

        // Redirigir (ajusta la ruta según tu index)
        return redirect()->route('dispositivos.index')->with('success', 'Dispositivo registrado correctamente.');
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
        return view('cpanel.dispositivos.editdispositivos', compact('dispositivo', 'clientes'));
    }

    /**
     * Procesa la actualización en la base de datos
     */
    public function update(Request $request, $id)
    {
        // 1. Validación de datos
        $request->validate([
            'tipo' => 'required|string|max:30',
            'marca' => 'required|string|max:20',
            'modelo' => 'required|string|max:20',
            'id_client_fk' => 'required|exists:cliente,ID_client',
        ]);

        // 2. Actualizar registro
        DB::table('dispositivo')
            ->where('ID_tel', $id)
            ->update([
                'tipo' => $request->input('tipo'),
                'marca' => $request->input('marca'),
                'modelo' => $request->input('modelo'),
                'id_client_fk' => $request->input('id_client_fk')
            ]);

        // 3. Redireccionar
        return redirect('tecnico/dispositivos')
            ->with('success', 'Dispositivo actualizado correctamente.');
    }

    public function destroy($id){
        DB::table('dispositivo')->where('ID_tel', '=', $id)->delete();


        return redirect('/tecnico/dispositivos')->with('success', 'Cliente eliminado correctamente.');

    }
}
