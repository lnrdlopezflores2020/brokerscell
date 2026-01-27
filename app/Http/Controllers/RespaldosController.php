<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RespaldosController extends Controller
{
    // Muestra la vista del panel de respaldo
    public function index()
    {
        return view('cpanel/respaldos/indexRespaldos');
    }

    // Genera y descarga el backup
    public function descargar(Request $request)
    {
        // 1. Validamos que haya escrito algo
        $request->validate([
            'password' => 'required'
        ]);

        // 2. Verificamos que la contraseña sea la REAL del administrador conectado
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->with('error', 'La contraseña de administrador es incorrecta.');
        }

        // 3. Configuración del archivo y Base de Datos
        $filename = "backup-" . date('Y-m-d_H-i-s') . ".sql";
        $path = storage_path('app/' . $filename); // Guardamos temporalmente en storage

        // Credenciales desde el archivo .env
        $dbDatabase = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');

        // 4. Comando para generar el respaldo (mysqldump)
        // NOTA: Si estás en Windows (XAMPP) y falla, es posible que necesites la ruta completa a mysqldump
        // Ej: "C:/xampp/mysql/bin/mysqldump"
        $command = "mysqldump --user={$dbUser} --password={$dbPassword} --host={$dbHost} {$dbDatabase} > {$path}";

        // En algunos entornos locales la contraseña vacía da problemas con el flag -p, ajustamos:
        if(empty($dbPassword)){
            $command = "mysqldump --user={$dbUser} --host={$dbHost} {$dbDatabase} > {$path}";
        }

        try {
            // Ejecutamos el comando en la consola del servidor
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Si mysqldump falla (ej. no está en el PATH)
                \Log::error("Error al generar respaldo: " . implode("\n", $output));
                return back()->with('error', 'Error del sistema: No se pudo ejecutar mysqldump. Revisa los logs.');
            }

            // 5. Descargamos el archivo y lo borramos del servidor inmediatamente
            return response()->download($path)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}
