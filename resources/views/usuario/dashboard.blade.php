<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏋️‍♂️ Mi Espacio Fitness
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10">

        <h3 class="text-2xl font-bold mb-6 text-gray-700">
            Hola, {{ Auth::user()->name }}👋
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Gestión de clases --}}
            <a href="{{ route('reservaClases') }}"
                class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl transition border border-gray-200">
                <div class="text-5xl mb-3">🏋️‍♂️</div>
                <h4 class="text-xl font-semibold text-gray-800">Clases</h4>
                <p class="text-gray-500 text-center mt-2">Reservar y anular clases</p>
            </a>
            {{-- Renovar cuota --}}
            <a href="{{ route('renovarCuota') }}"
                class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl transition border border-gray-200">
                <div class="text-5xl mb-3">💳</div>
                <h4 class="text-xl font-semibold text-gray-800">Cuota</h4>
                <p class="text-gray-500 text-center mt-2">Renovar cuota</p>
            </a>
            {{-- Contacto --}}
            <a href="{{ route('contacto') }}"
                class="bg-white shadow-lg rounded-xl p-6 flex flex-col items-center justify-center hover:shadow-2xl transition border border-gray-200">
                <div class="text-5xl mb-3">📱</div>
                <h4 class="text-xl font-semibold text-gray-800">Contacto</h4>
                <p class="text-gray-500 text-center mt-2">Sugerencias, agradecimientos, quejas</p>
            </a>
        </div>
    </div>

</x-app-layout>