<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('administrador.registroUsuarios');
    }

    public function index()
    {
        $usuarios = User::orderBy('name')->get();
        return view('administrador.listadoUsuarios', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['email' => strtolower(trim($request->email))]);
        $datos = $request->validate([
            'name'      => ['required', 'string', 'max:50'],
            'dni'       => ['required', 'string', 'max:9', 'unique:users,dni'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'email'     => ['required', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'telefono'  => ['required', 'string', 'max:9'],
            'password'  => ['required', 'min:6'],
            'rol'       => ['required', Rule::in([User::ROLE_USUARIO, User::ROLE_ADMINISTRADOR])],
            'membresia' => ['required', 'string'],
        ]);

        // El cast 'hashed' del modelo encripta la contraseña, no hace falta bcrypt
        //User::create($datos);

        //return redirect()->route('usuarios.listado')
        // ->with('success', 'Usuario creado correctamente');
        //}
        User::create($datos);

        return redirect()
            ->route('administrador.dashboard')
            ->with('status', 'Usuario creado correctamente.');
    }


    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('administrador.editarRegistroUsuario', compact('usuario'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $usuario = User::findOrFail($id);

        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:50'],
            'email'    => [
                'required',
                'email',
                'lowercase',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id)
            ],
            'telefono' => ['required', 'string', 'max:9'],
            'rol'      => ['required', Rule::in([User::ROLE_USUARIO, User::ROLE_ADMINISTRADOR])],
        ]);

        $usuario->update($datos);

        return redirect()->route('administrador.dashboard')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(string $id): RedirectResponse
    {
        $usuario = User::findOrFail($id);

        // Evita que el administrador se borre a sí mismo
        if ($usuario->id === auth()->id()) {
            return redirect()->route('usuarios.listado')
                ->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $usuario->delete();

        return redirect()->route('usuarios.listado')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
