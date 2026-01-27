<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UsuariosController extends Controller
{
    public function index(){
        $clientes = DB::table('usuario');
        $fila = $clientes->get();
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

        // 2. Insertamos mapeando INPUT HTML -> COLUMNA BD
        DB::table('usuario')->insert([
            'emai' => $request->input('email'),        // Input 'email' va a columna 'emai'
            'rol_usuario' => $request->input('rol'),   // Input 'rol' va a columna 'rol_usuario'
            'contrasenia' => Hash::make($request->input('password')) // Input 'password' va a 'contrasenia'
        ]);

        return redirect()->route('usuarios.index');
    }

    public function destroy($id){
        DB::table('usuario')->where('ID_usuario', '=', $id)->delete();
        return redirect()->route('usuarios.index');
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

        // 4. Ejecutamos el update
        DB::table('usuario')->where('ID_usuario', $id)->update($datosParaActualizar);

        return redirect()->route('usuarios.index');
    }

    public function descargarReporteExcel()
    {
        return Excel::download(new UsersExport, 'reporte_usuarios.xlsx');
    }


}
