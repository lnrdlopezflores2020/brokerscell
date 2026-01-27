<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DispositivosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReparacionesController;
use App\Http\Controllers\TecnicosController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\DashboardClientescoltroller;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\RespaldosController;

use App\Http\Controllers\ActualizarReparacionesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('cpanel/Home');
})->name('SoluxMovil');


// Ruta para VER el formulario (GET)
Route::get('/login', [LoginController::class, 'mostrarFormulario'])->name('login');
// Ruta para PROCESAR el formulario (POST)
Route::post('/login', [LoginController::class, 'validarLogin'])->name('login.validate');

// Rutas de 2FA (Paso 2)
Route::get('/login/verificar-2fa', [LoginController::class, 'mostrarFormulario2FA'])->name('2fa.index');
Route::post('/login/verificar-2fa', [LoginController::class, 'confirmar2FA'])->name('2fa.confirmar');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/api/clientes/{id}/dispositivos', [ReparacionesController::class, 'getDispositivos']);



Route::middleware(['auth', 'role:administrador'])->prefix('admon')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('inicio.index');

    Route::get('perfilUsuario', function () {
        return view('cpanel/usuarios/perfilusuario');
    })->name('perfilUsuario');

    // 2. Clientes (URL final: /admon/clientes)
    Route::resource('clientes', ClientesController::class);

    // 3. Usuarios (URL final: /admon/usuarios)
    Route::resource('usuarios', UsuariosController::class);

    // 4. Reportes
    Route::get('reportes/usuarios/excel', [UsuariosController::class, 'descargarReporteExcel'])->name('reportes.excel');
    Route::get('reportes/pdfClientes', [ReportesController::class, 'GenerarPDF']);
    Route::get('reportes/reparaciones', [ReportesController::class, 'GenerarHistorial']);
    Route::get('reportes/nota/{id}', [ReportesController::class, 'generarNota'])->name('admon_reportes.nota');
    Route::get('reportes/excel-clientes', [ClientesController::class, 'exportarExcel'])
        ->name('reportes.excel');

    Route::resource('dispositivos', DispositivosController::class);
    Route::resource('tecnicos', TecnicosController::class);
    Route::resource('reparaciones', ReparacionesController::class);
    Route::get('respaldos', [RespaldosController::class, 'index'])->name('admon.respaldos');
    Route::post('respaldos/descargar', [RespaldosController::class, 'descargar'])->name('admon.respaldo.descargar');

});

Route::middleware(['auth', 'role:tecnico'])->prefix('tecnico')->group(function () {

    Route::get('/', [TecnicosController::class, 'dashboard'])
        ->name('tecnico.index');

    Route::get('perfilUsuario', function () {
        return view('cpanel/usuarios/perfilusuario');
    })->name('perfilusuario');

    Route::resource('clientes', ClientesController::class);

    Route::resource('dispositivos', DispositivosController::class);

    Route::resource('reparaciones', ReparacionesController::class);
    Route::get('reportes/nota/{id}', [ReportesController::class, 'generarNota'])->name('reportes.nota');

    Route::resource('Actualizar',ActualizarReparacionesController::class);

});

Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->group(function () {
    Route::resource('/',DashboardClientescoltroller::class);
    Route::resource('/Mis-reparaciones', \App\Http\Controllers\ConsultasController::class);
    Route::get('perfilUsuario', function () {
        return view('cpanel/usuarios/perfilusuario');
    })->name('perfilCliente');
    Route::get('/cliente/nota-entrega/{id}', [ReportesController::class, 'generarNotaEntrega'])
        ->name('cliente.nota_entrega');

    Route::get('soporte', function () {
        return view('cpanel/ChatBot/Chatbot');
    })->name('cliente.soporte');
});












