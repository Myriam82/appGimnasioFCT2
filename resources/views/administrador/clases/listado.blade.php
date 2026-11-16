<x-app-layout>
    <h1>Listado de clases</h1>
    {{-- Botón --}}
    <a href="{{ route('clases.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
        ⬅ Volver
    </a>
    <a href="{{ route('clases.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition mb-4">
        ➕ Registrar clase
    </a>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID</th>
                <th class="border p-2">Nombre clase</th>
                <th class="border p-2">Categoría</th>
                <th class="border p-2">Día</th>
                <th class="border p-2">Hora inicio</th>
                <th class="border p-2">Hora fin</th>
                <th class="border p-2">Capacidad máxima</th>
                <th class="border p-2">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clases as $clase)
            <tr>
                <td class="border p-2">{{ $clase->id }}</td>
                <td class="border p-2">{{ $clase->nombreClase }}</td>
                <td class="border p-2">{{ $clase->categoria }}</td>
                <td class="border p-2">{{ $clase->diaDeLaSemana }}</td>
                <td class="border p-2">{{ $clase->hora_inicio }}</td>
                <td class="border p-2">{{ $clase->hora_fin }}</td>
                <td class="border p-2">{{ $clase->capacidad_maxima }}</td>
                <td class="border p-2">{{ $clase->estado }}</td>
                <td class="border p-2">
                    <form action="{{ route('clases.destroy', $clase->id) }}" method="POST"
                        onsubmit="return confirm('¿Seguro que deseas borrar esta clase?');">
                        @csrf
                        @method('DELETE')

                        <button class="flex items-center gap-2 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Borrar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>