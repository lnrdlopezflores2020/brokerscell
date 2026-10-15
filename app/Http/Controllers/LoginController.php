<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function mostrarFormulario()
    {
        return view('cpanel/auth/login');
    }

    public function validarLogin(Request $request)
    {
        // 1. Validar inputs
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // 2. Credenciales (respetando la columna 'emai' de tu BD)
        $credenciales = [
            'emai'     => $request->email,
            'password' => $request->password
        ];

        // 3. Validar credenciales
        if (Auth::validate($credenciales)) {

            // Buscamos al usuario
            $user = User::where('emai', $request->email)->first();

            // INICIO DE SESIÓN DIRECTO (Sin código 2FA ni correos)
            Auth::login($user);
            $request->session()->regenerate();

            // Redirección inmediata según su rol
            switch ($user->rol_usuario) {
                case 'administrador':
                    return redirect()->route('inicio.index');

                case 'tecnico':
                    return redirect()->route('tecnico.index');

                case 'cliente':
                    return redirect()->route('index');

                default:
                    return redirect('/');
            }
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Métodos de 2FA conservados por si los necesitas después, pero ya no se ejecutan en el login
    public function mostrarFormulario2FA()
    {
        if (!session()->has('user_2fa_id')) {
            return redirect()->route('login');
        }
        return view('cpanel/auth/verify-2fa');
    }

    public function confirmar2FA(Request $request)
    {
        return redirect()->route('login');
    }
}