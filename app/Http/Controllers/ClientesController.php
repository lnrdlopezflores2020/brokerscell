<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cliente;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail; // IMPORTACIÓN PARA CORREOS
use App\Mail\BienvenidaClienteMail; // IMPORTACIÓN DE LA PLANTILLA DE CORREO
use Exception;

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
        $usuariosClientes = User::where('rol_usuario', 'cliente')
            ->orWhere('rol_usuario', 'Cliente')
            ->select('ID_usuario', 'emai') // Ajusta 'emai' si en BD es 'email'
            ->get();

        $fila = new \stdClass();

        return view('cpanel/clientes/createclientes', compact('usuariosClientes', 'fila'));
    }

    public function store(Request $request){
        // 1. Recibimos el ID del usuario
        $Usuario = $request->input('usuario_fk');

        // --- VALIDACIÓN DE DUPLICADOS ---
        $existe = DB::table('cliente')
            ->where('usuario_fk', $Usuario)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Error: El usuario seleccionado ya tiene un cliente asignado.');
        }

        // 2. Insertamos en la Base de Datos
        DB::table('cliente')->insert([
            'nombre'     => $request->input('nombre'),
            'apellido'   => $request->input('apellido'),
            'telefono'   => $request->input('telefono'),
            'direccion'  => $request->input('direccion'),
            'num_ext'    => $request->input('num_ext'),
            'num_int'    => $request->input('num_int'),
            'usuario_fk' => $Usuario,
        ]);

        // --- 3. ENVÍO DE CORREO DE BIENVENIDA ---
        try {
            // Buscamos el correo en la tabla de usuarios asociados
            $userAsociado = User::find($Usuario);
            
            // Verificamos que exista y tenga correo (emai / email)
            if ($userAsociado && $userAsociado->emai) { 
                Mail::to($userAsociado->emai)->send(new BienvenidaClienteMail($request->input('nombre')));
            }
        } catch (Exception $e) {
            // Si falla el envío (ej. credenciales SMTP incorrectas), no bloqueamos el sistema.
            // Solo registramos el error internamente.
            \Log::error('Error al enviar correo de bienvenida: ' . $e->getMessage());
        }

        // 4. REDIRECCIÓN SEGURA
        if (auth()->user()->rol_usuario === 'administrador') {
            return redirect('/admon/clientes')->with('success', 'Cliente guardado correctamente. Se ha enviado un correo de bienvenida.');
        } else {
            return redirect('/tecnico/clientes')->with('success', 'Cliente guardado correctamente. Se ha enviado un correo de bienvenida.');
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
        $fila = DB::table('cliente')->where('ID_client', '=', $id)->first();

        $usuariosClientes = User::where('rol_usuario', 'cliente')
            ->orWhere('rol_usuario', 'Cliente')
            ->select('ID_usuario', 'emai')
            ->get();

        return view('cpanel/clientes/editclientes', compact('fila', 'usuariosClientes'));
    }

    public function update(Request $request, $id){
        $datosUsuario = request()->except(['_token','_method']);

        DB::table('cliente')->where('ID_client', $id)->update([
            'nombre'     => $datosUsuario['nombre'],
            'apellido'   => $datosUsuario['apellido'],
            'telefono'   => $datosUsuario['telefono'],
            'direccion'  => $datosUsuario['direccion'],
            'num_ext'    => $datosUsuario['num_ext'],
            'num_int'    => $datosUsuario['num_int'],
            'usuario_fk' => $datosUsuario['usuario_fk']
        ]);

        if (auth()->user()->rol_usuario === 'administrador') {
            return redirect('/admon/clientes')->with('success', 'Información actualizada correctamente.');
        } else {
            return redirect('/tecnico/clientes')->with('success', 'Información actualizada correctamente.');
        }
    }

    public function exportarExcel()
    {
        return Excel::download(new ClientesExport, 'Reporte_Solo_Clientes.xlsx');
    }
}