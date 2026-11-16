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
            🛠️ Panel de administración
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto py-6">

        <!--  @if(session('success'))
        <div class="bg-green-500 text-black p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif-->

        <a href="{{ route('administrador.dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
            ⬅ Volver al panel
        </a>
        <a href="{{ route('usuarios.alta') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
            ➕ Alta usuario
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Listado de usuarios
        </h2>
        <br>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Dni</th>
                        <th class="p-3 text-left">Nombre</th>
                        <th class="p-3 text-left">Direccion</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Teléfono</th>
                        <th class="p-3 text-left">Rol</th>
                        <th class="p-3 text-left">Membresia</th>
                        <th class="p-3 text-left">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3">{{ $usuario->id }}</td>
                        <td class="p-3">{{ $usuario->dni }}</td>
                        <td class="p-3">{{ $usuario->name }}</td>
                        <td class="p-3">{{ $usuario->direccion }}</td>
                        <td class="p-3">{{ $usuario->email }}</td>
                        <td class="p-3">{{ $usuario->telefono }}</td>
                        <td class="p-3">{{ $usuario->rol }}</td>
                        <td class="p-3">{{ $usuario->membresia }}</td>

                        <td class="p-3 flex gap-2">
                            <a href="{{ route('administrador.listadoUsuarios.edit', $usuario->id) }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                ✏
                            </a>

                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    🗑
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</x-app-layout>