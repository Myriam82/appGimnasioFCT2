<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UsuarioController extends Controller
{
    public function create()
    {
        return view('administrador.registroUsuarios');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$usuario = User::where('rol'. User::ROL_USUARIO)CON ORDER O SIN 
        // Y AHORA RETORNARIA UNA VISTA CON EL COMPACT
        $usuarios = User::all();
        return view('administrador.listadoUsuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        //Validación básica de los datos del usuario
        $request->validate([
            'name' => 'required',
            'dni' => 'required',
            'direccion' => 'required',
            'email' => 'required|email|unique:users',
            'telefono' => 'nullable',
            'password' => 'required|min:6',
            'rol' => 'required',
            'membresia' => 'required',
        ]);
        //Creación del usuario en la BD
        $user = User::create([
            'name' => $request->name,
            'dni' => $request->dni,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => bcrypt($request->password),
            'rol' => $request->rol,
            'membresia' => $request->membresia,
        ]);

        return redirect()->route('usuarios.listado')
            ->with('success', 'Usuario creado correctamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Buscar el usuario por ID, si existe lo guarda en $usuario sino lanza error 404
        $usuario = User::findOrFail($id);
        //Se actualizan los campos del usuario
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'rol' => $request->rol,
        ]);
        //Redirije mensaje de éxito
        return redirect()->route('administrador.dashboard')->with('success', 'Usuario actualizado correctamente');
    }
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('administrador.editarRegistroUsuario', compact('usuario'));
    }

    /**
     * Remove the specified resource from storage.
     */
    //Función para borrar un registro de usuario
    public function destroy(Request $request, User $user, string $id): RedirectResponse
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.listado')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
