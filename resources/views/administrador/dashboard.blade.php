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

    <div class="max-w-7xl mx-auto py-10">

        <h3 class="text-2xl font-bold mb-6 text-gray-700">
            Hola, {{ Auth::user()->name }}👋
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Gestión de usuarios --}}
            <a href="{{ route('usuarios.listado') }}"
                class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl transition border border-gray-200">
                <div class="text-5xl mb-3">👤</div>
                <h4 class="text-xl font-semibold text-gray-800">Usuarios</h4>
                <p class="text-gray-500 text-center mt-2">Gestionar usuarios del gimnasio</p>
            </a>
            {{-- Gestión de clases --}}
            <a href="{{ route('clases.listado') }}"
                class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl transition border border-gray-200">
                <div class="text-5xl mb-3">🏋️‍♂️</div>
                <h4 class="text-xl font-semibold text-gray-800">Clases</h4>
                <p class="text-gray-500 text-center mt-2">Ver y administrar clases</p>
            </a>
            {{-- Listado de Usuarios --}}
            <a href="{{ route('usuarios.listado') }}"
                class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl transition border border-gray-200">
                <div class="text-5xl mb-3">📋</div>
                <h4 class="text-xl font-semibold text-gray-800">Listado de Usuarios</h4>
                <p class="text-gray-500 text-center mt-2">Crear y administrar Usuarios</p>
            </a>
        </div>
    </div>
</x-app-layout>