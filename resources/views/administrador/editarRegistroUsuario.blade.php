<x-app-layout>
    @if(session('success'))
    <div class="bg-gray-200 text-black p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    @if (session('info'))
    <div class="bg-gray-200 text-black p-3 rounded mb-4">
        {{ session('info') }}
    </div>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛠️{{ __('Panel de administracion') }}
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Editar usuario
        </h2>
    </x-slot>
    <form action="{{ route('administrador.listadoUsuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h2 class="font-bold text-lg mt-6 mb-2">DATOS PERSONALES</h2>
        <!-- Nombre -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Nombre completo</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                placeholder="Ej: Laura Martínez" required>

        </div>
        <!-- DNI -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Dni</label>
            <input type="text" name="dni" value="{{ old('dni', $usuario->dni) }}"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                placeholder="Ej: 28789675-Y" required>
        </div>

        <!-- Dirección -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $usuario->direccion) }}"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                placeholder="Ej: C/ Orquídea" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Correo electrónico</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                placeholder="ejemplo@correo.com" required>
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                placeholder="Ej: 612345678">
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-1">Contraseña</label>
            <input type="password" name="password" value="{{ old('password', $usuario->password) }}"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300"
                placeholder="Mínimo 6 caracteres" required>
        </div>
        <h2 class="font-bold text-lg mt-6 mb-2">CONFIGURACIÓN DEL USUARIO</h2>
        <!-- Rol -->
        <div class="mt-6">
            <label class="block text-gray-700 font-semibold">Rol</label>
            <select name="rol" class="w-full border rounded-lg p-2" required>
                <option value="usuario" {{ $usuario->rol == 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <!-- Membresía -->
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-1">Tipo de membresía</label>
            <select name="membresia"
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-300">
                <option value="mensual">Mensual</option>
                <option value="trimestral">Trimestral</option>
                <option value="anual">Anual</option>
            </select>
        </div>


        {{-- Botón --}}
        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
            Guardar cambios
        </button>
    </form>
</x-app-layout>