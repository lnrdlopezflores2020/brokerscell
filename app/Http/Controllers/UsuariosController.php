<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use Illuminate\Database\QueryException; // IMPORTACIÓN PARA MANEJAR ERRORES DE BD

class UsuariosController extends Controller
{
    public function index(){
        $clientes = DB::table('usuario');
        $fila = $clientes->paginate(10);
        return view('cpanel/usuarios/indexusuarios', ['data' => $fila]);
    }

    public function create(){
        return view('cpanel/usuarios/createusuarios');
    }

    // --- STORE: GUARDAR NUEVO ---
    public function store(Request $request){

        // 1. Validamos que los datos vengan del HTML
        $request->validate([
            'email' => 'required|email', // Valida que sea email
            'password' => 'required|min:8', // Valida mínimo 8 caracteres
            'rol' => 'required'
        ]);

        try {
            // 2. Insertamos mapeando INPUT HTML -> COLUMNA BD
            DB::table('usuario')->insert([
                'emai' => $request->input('email'),        // Input 'email' va a columna 'emai'
                'rol_usuario' => $request->input('rol'),   // Input 'rol' va a columna 'rol_usuario'
                'contrasenia' => Hash::make($request->input('password')) // Input 'password' va a 'contrasenia'
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');

        } catch (QueryException $e) {
            // Manejo de Error de Duplicidad (Código 1062 en MySQL)
            if ($e->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', 'Error: El correo electrónico ingresado ya está registrado en otra cuenta.');
            }
            return back()->withInput()->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        if (strtolower($usuario->rol_usuario) === 'administrador' || strtolower($usuario->rol_usuario) === 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar a un administrador.');
        }

        try {
            $usuario->delete();
            return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
        } catch (QueryException $e) {
            // Error 1451: Intentar eliminar un usuario que ya está asignado a un cliente o técnico
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'No se puede eliminar este usuario porque ya está vinculado a un Cliente o Técnico en el sistema.');
            }
            return back()->with('error', 'Error al intentar eliminar el registro.');
        }
    }

    public function edit($id){
        $fila = DB::table('usuario')->where('ID_usuario', '=', $id)->first();
        return view('cpanel/usuarios/editusuarios',['fila'=>$fila]);
    }

    // --- UPDATE: ACTUALIZAR EXISTENTE ---
    public function update(Request $request, $id){

        // 1. Validamos (Password es 'nullable' porque puede que no quiera cambiarla)
        $request->validate([
            'email' => 'required|email',
            'rol' => 'required',
            'password' => 'nullable|min:8|confirmed' // 'confirmed' revisa si coincide con password_confirmation
        ]);

        // 2. Preparamos los datos básicos a actualizar
        $datosParaActualizar = [
            'emai' => $request->input('email'),
            'rol_usuario' => $request->input('rol')
        ];

        // 3. Lógica inteligente para la contraseña:
        // Solo si el usuario escribió algo en el campo 'password', lo encriptamos y lo agregamos.
        // Si lo dejó vacío, NO tocamos la columna 'contrasenia' en la BD.
        if ($request->filled('password')) {
            $datosParaActualizar['contrasenia'] = Hash::make($request->input('password'));
        }

        try {
            // 4. Ejecutamos el update
            DB::table('usuario')->where('ID_usuario', $id)->update($datosParaActualizar);

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');

        } catch (QueryException $e) {
            // Manejo de Error de Duplicidad al actualizar
            if ($e->errorInfo[1] == 1062) {
                return back()->withInput()->with('error', 'Error: El correo electrónico ya está en uso por otro usuario.');
            }
            return back()->withInput()->with('error', 'Ocurrió un error al actualizar los datos.');
        }
    }

    public function descargarReporteExcel()
    {
        return Excel::download(new UsersExport, 'reporte_usuarios.xlsx');
    }
}
