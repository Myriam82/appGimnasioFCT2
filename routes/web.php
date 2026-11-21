<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuario\UsuarioDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ClaseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UsuarioController;

use App\Http\Controllers\Usuario\CuotaController;
use App\Http\Controllers\Usuario\PagoController; 

use App\Http\Controllers\Admin\CuotaController as AdminCuotaController;
use App\Http\Controllers\Admin\PagoController as AdminPagoController;


// Raíz: formulario de login
Route::get('/', function () {
    return view('auth.login');
});

// Redirección según rol (la hace el middleware redirect.role)
Route::get('/dashboard', function () {
    // Esta vista nunca se muestra, el middleware redirige antes
})->middleware(['auth', 'redirect.role'])->name('dashboard');

// ---------- Cualquier usuario autenticado ----------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/calendario', [ClaseController::class, 'calendario'])->name('calendario');
    Route::get('/clases', [ClaseController::class, 'index'])->name('clases.index');

    Route::post('/clases/{id}/reservar', [UsuarioDashboardController::class, 'reservar'])->name('clases.reservar');
    Route::delete('/clases/{id}/anular', [UsuarioDashboardController::class, 'anular'])->name('clases.anular');

    Route::get('/reservaClases', [UsuarioDashboardController::class, 'mostrarClases'])->name('reservaClases');

    Route::get('/pagina-vacia', fn () => view('usuario.renovarCuota'))->name('renovarCuota');
    Route::get('/pagina-vaciaContacto', fn () => view('usuario.contacto'))->name('contacto');
});

// ---------- Solo administrador ----------
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/administrador/dashboard', [AdminDashboardController::class, 'index'])
        ->name('administrador.dashboard');

    // Usuarios
    Route::get('/usuarios/listado', [UsuarioController::class, 'index'])->name('usuarios.listado');
    Route::get('/usuarios/alta', [UsuarioController::class, 'create'])->name('usuarios.alta');
    Route::post('/usuarios/crear', [UsuarioController::class, 'store'])->name('register.user');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    Route::get('/administrador/usuarios/{id}/editar', [UsuarioController::class, 'edit'])
        ->name('administrador.listadoUsuarios.edit');
    Route::put('/administrador/usuarios/{id}', [UsuarioController::class, 'update'])
        ->name('administrador.listadoUsuarios.update');

    // Clases
    Route::get('/clases/crear', [ClaseController::class, 'create'])->name('clases.create');
    Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');
    Route::get('/clases/listado', [ClaseController::class, 'listado'])->name('clases.listado');
    Route::delete('/clases/{id}', [ClaseController::class, 'destroy'])->name('clases.destroy');
});

Route::resource('cuotas', AdminCuotaController::class)->only(['index', 'create', 'store', 'show']);
Route::post('cuotas/{cuota}/pagos', [AdminPagoController::class, 'store'])->name('cuotas.pagos.store');

// ---------- Solo usuario ----------
Route::middleware(['auth', 'role:usuario'])
    ->prefix('usuario')
    ->name('usuario.')
    ->group(function () {
        Route::get('/dashboard', [UsuarioDashboardController::class, 'index'])->name('dashboard');
    });


Route::middleware(['auth', 'role:usuario'])
    ->prefix('usuario')
    ->name('usuario.')
    ->group(function () {
        Route::get('mis-cuotas', [CuotaController::class, 'index'])->name('cuotas.index');
        Route::get('mis-cuotas/{cuota}', [CuotaController::class, 'show'])->name('cuotas.show');
        Route::get('mis-pagos', [PagoController::class, 'index'])->name('pagos.index');
    });
require __DIR__.'/auth.php';