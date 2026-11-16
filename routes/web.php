<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuario\UsuarioDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ClaseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UsuarioController;


// Si se solicita la ruta raíz, se sirve auth.login, que es la vista de autenticación de blade.
// Página raíz para que salga directamente el LOG IN
Route::get('/', function () {
    return view('auth.login');
});

// Ruta carga la página para mostrar el formulario de editar y que se pueda rellenar, GET-> Dame la página del formulario
Route::get(
    '/administrador/usuarios/{id}/editar',
    [UsuarioController::class, 'edit']
)->name('administrador.listadoUsuarios.edit');

// Ruta que recibe los datos del formulario, se validan y se vuelven a guardar en la BD, PUT-> Actualiza este recurso
Route::put(
    '/administrador/usuarios/{id}',
    [UsuarioController::class, 'update']
)->name('administrador.listadoUsuarios.update');


//Route::get('/clases', [AdminClaseController::class, 'index'])->name('clases.index');

//Esta es la página de bienvenida
//Route::get('/', function () {
// return view('welcome');
//});

Route::get('/dashboard', function () {
    // Esta vista nunca se muestra, el middleware redirige antes
})->middleware(['auth', 'redirect.role'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/clases/{id}/reservar', [ClaseController::class, 'reservar'])->name('clases.reservar');

//Ruta que el usuario puede reservar una clase
Route::post('/clases/{id}/reservar', [UsuarioDashboardController::class, 'reservar'])->middleware('auth')->name('clases.reservar');

//Route::delete('/clases/{id}/anular', [ClaseController::class, 'anular'])->middleware('auth')->name('clases.anular');
Route::delete('/clases/{id}/anular', [UsuarioDashboardController::class, 'anular'])->middleware('auth')->name('clases.anular');

Route::get('/admin/users', [UsuarioController::class, 'index'])
    ->name('admin.users.index');

//Usuarios    
Route::post('/usuarios/crear', [UsuarioController::class, 'store'])
    ->name('register.user');

Route::get('/usuarios/alta', [UsuarioController::class, 'create'])
    ->name('usuarios.alta');

// Mostrar formulario
Route::get('/clases/crear', [ClaseController::class, 'create'])->name('clases.create');

// Guardar clase
Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');

Route::get('/clases', [ClaseController::class, 'index'])->name('clases.index');

//El administrador puede borrar de la lista de clases, una clase
Route::delete('/clases/{id}', [ClaseController::class, 'destroy'])->name('clases.destroy');

Route::get('/calendario', [ClaseController::class, 'calendario'])
    ->middleware('auth')
    ->name('calendario');
// Mostrar formulario
Route::get('/clases/crear', [ClaseController::class, 'create'])->name('clases.create');
//Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store');

Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

// Route::middleware(['auth', 'role:administrador'])->prefix('administrador')->name('administrador.')->group(function () {
//     //Evitamos con esto que el usuario entre en el administrador
//     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
//     Route::resource('users', UsuarioController::class);
//     Route::resource('clases', AdminClaseController::class);
// });

Route::middleware(['auth', 'role:administrador'])
    ->prefix('administrador')
    ->name('administrador.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

Route::middleware(['auth', 'role:usuario'])
    ->prefix('usuario')
    ->name('usuario.')
    ->group(function () {
        Route::get('/dashboard', [UsuarioDashboardController::class, 'index'])
            ->name('dashboard');
    });
//El administrador puede ver el listado de usuarios dados de alta
Route::get('/usuarios/listado', [UsuarioController::class, 'index'])
    ->name('usuarios.listado');

//listado de clases, del lado del administrador
Route::get('/clases/listado', [ClaseController::class, 'listado'])
    ->name('clases.listado');

//Ruta para la página en construccion para renovar la cuota
Route::get('/pagina-vacia', function () {
    return view('usuario.renovarCuota');
})->name('renovarCuota');

//Ruta para la página en construccion para contacto (Sugerencias, quejas...)
Route::get('/pagina-vaciaContacto', function () {
    return view('usuario.contacto');
})->name('contacto');


Route::get('/reservaClases', [UsuarioDashboardController::class, 'mostrarClases'])
    ->middleware('auth')
    ->name('reservaClases');



require __DIR__ . '/auth.php';
