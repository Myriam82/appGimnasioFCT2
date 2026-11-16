<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">

        <h1 class="text-2xl font-bold mb-6">Registrar nueva clase</h1>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🛠️ Panel de administración
            </h2>
        </x-slot>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('clases.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nombre de la clase</label>
                <input type="text" name="nombreClase" class="w-full border p-2 rounded" required>
            </div>

            {{-- Categoría --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Categoría</label>
                <select name="categoria" class="w-full border p-2 rounded">
                    <option value="Cardio">Cardio</option>
                    <option value="Fuerza">Fuerza</option>
                    <option value="Baile">Baile</option>
                    <option value="Relajación">Relajación</option>
                </select>
            </div>

            {{-- Día --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Día de la semana</label>
                <select name="diaDeLaSemana" class="w-full border p-2 rounded">
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
            </div>

            {{-- Horarios --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-semibold mb-1">Hora de inicio</label>
                    <input type="time" name="hora_inicio" class="w-full border p-2 rounded" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Hora de fin</label>
                    <input type="time" name="hora_fin" class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                {{-- Fecha desde --}}
                <div>
                    <label class="block font-semibold mb-1">Fecha desde</label>
                    <input type="date" name="fecha_desde" class="w-full border p-2 rounded" required>
                </div>
                {{-- Fecha hasta --}}
                <div>
                    <label class="block font-semibold mb-1">Fecha hasta</label>
                    <input type="date" name="fecha_hasta" class="w-full border p-2 rounded" required>
                </div>
            </div>

            {{-- Capacidad --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Capacidad máxima</label>
                <input type="number" name="capacidad_maxima" class="w-full border p-2 rounded" min="1" required>
            </div>

            {{-- Estado --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Estado</label>
                <select name="estado" class="w-full border p-2 rounded">
                    <option value="activa">Activa</option>
                    <option value="inactiva">Inactiva</option>
                </select>
            </div>

            {{-- Botón --}}
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
                ➕ Guardar clase
            </button>

            {{-- Botón --}}
            <a href="{{ route('clases.listado') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
                📋Listado de clases
            </a>
            {{-- Botón --}}
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
                ⬅ Volver al panel
            </a>

        </form>
    </div>
</x-app-layout>