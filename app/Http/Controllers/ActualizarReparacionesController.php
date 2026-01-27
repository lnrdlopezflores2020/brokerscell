<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use Illuminate\Http\Request;

class ActualizarReparacionesController extends Controller
{
    public function index(Request $request)
    {
        $query = Reparacion::query(); // O DB::table('reparaciones')

        // Lógica del filtro
        if ($request->has('busqueda') && $request->busqueda != '') {
            $query->where('ID_rep', 'LIKE', '%' . $request->busqueda . '%');
        }

        $data = $query->orderBy('ID_rep', 'desc')->get(); // O ->paginate(10);

        return view('cpanel/reparaciones/indexActRep', compact('data'));
    }

    public function edit($id){
        // Cargar la reparación con el dispositivo y el cliente asociado
        $reparacion = Reparacion::with('dispositivo.cliente')->findOrFail($id);

        return view('cpanel/reparaciones/editreparacion', compact('reparacion'));

    }

    public function update(Request $request, $id)
    {
        // 1. Validamos que el campo no venga vacío
        $request->validate([
            'est_reparacion' => 'required|string'
        ]);

        // 2. Buscamos la reparación por su ID
        $reparacion = Reparacion::findOrFail($id);

        // 3. Actualizamos SOLO el estado
        // Nota: Los otros campos (cliente, dispositivo, costo) no se actualizan
        // porque en la vista los pusimos como 'disabled' (solo lectura).
        $reparacion->est_reparacion = $request->input('est_reparacion');

        // 4. Guardamos los cambios
        $reparacion->save();

        // 5. Redireccionamos según el rol del usuario (Admin o Técnico)
        return redirect('/tecnico/reparaciones');
    }
}
