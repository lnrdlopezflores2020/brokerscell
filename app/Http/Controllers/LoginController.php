<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Para manejar fechas
use Illuminate\Support\Facades\Mail;
use App\Mail\Codigo2FAMail;
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

        // 2. Credenciales (Input vs Tu BD)
        $credenciales = [
            'emai'     => $request->email,
            'password' => $request->password
        ];

        // 3. Validamos SIN iniciar sesión (Auth::validate)
        if (Auth::validate($credenciales)) {

            // Buscamos al usuario
            $user = User::where('emai', $request->email)->first();

            // Generamos código y fecha de expiración (10 mins)
            $codigo = rand(100000, 999999);
            $user->codigo_2fa = $codigo;
            $user->expiracion_2fa = Carbon::now()->addMinutes(10);
            $user->save();

            try {
                Mail::to($request->email)->send(new Codigo2FAMail($codigo));
            } catch (\Exception $e) {
                // COMENTA O BORRA ESTO TEMPORALMENTE:
                // return back()->withErrors(['email' => 'No se pudo enviar el correo...']);

                // AGREGA ESTO PARA VER EL ERROR REAL EN PANTALLA NEGRA:
                dd($e->getMessage());
            }

            // GUARDAMOS EL ID EN SESIÓN TEMPORAL
            // Esto es clave: el usuario aún no está logueado, pero recordamos quién intenta entrar
            session(['user_2fa_id' => $user->ID_usuario]);

            return redirect()->route('2fa.index');
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

    public function mostrarFormulario2FA()
    {
        // Si no hay un ID en espera, lo mandamos al login
        if (!session()->has('user_2fa_id')) {
            return redirect()->route('login');
        }
        return view('cpanel/auth/verify-2fa'); // La vista del paso 4
    }

    public function confirmar2FA(Request $request)
    {
        $request->validate(['codigo' => 'required|numeric']);

        // Recuperamos al usuario que estaba esperando
        $userId = session('user_2fa_id');
        $user = User::find($userId);

        if ($user && $user->codigo_2fa == $request->codigo && Carbon::now()->lt($user->expiracion_2fa)) {

            // ¡ÉXITO! Ahora sí iniciamos sesión oficial
            Auth::login($user);

            // Limpieza: Borramos código y sesión temporal
            $user->codigo_2fa = null;
            $user->expiracion_2fa = null;
            $user->save();
            session()->forget('user_2fa_id');
            $request->session()->regenerate();

            switch ($user->rol_usuario) {

                case 'administrador': // Asegúrate que esté escrito IGUAL que en tu BD
                    return redirect()->route('inicio.index');
                    break;

                case 'tecnico':
                    // Debes tener una ruta llamada 'tecnico.dashboard'
                    return redirect()->route('tecnico.index');
                    break;

                case 'cliente':
                    // Debes tener una ruta llamada 'cliente.inicio'
                    return redirect()->route('index');
                    break;

                default:
                    // Si el rol no coincide con ninguno, mándalo al home genérico
                    return redirect('/');
            }
        }

        return back()->withErrors(['codigo' => 'Código incorrecto o expirado.']);
    }
}
