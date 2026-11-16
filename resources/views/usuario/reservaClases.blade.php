<style>
    .animated-slide {
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reserva de clases') }}
        </h2>
        <br>
        <a href="{{ route('usuario.dashboard') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
            ⬅ Volver al panel
        </a>
    </x-slot>

    {{-- CARRUSEL DE DÍAS --}}
    <div class="flex gap-2 overflow-x-auto py-2 justify-center">
        @foreach ($diasCarrusel as $dia)
        <a href="{{ route('reservaClases', ['fecha' => $dia->toDateString()]) }}"
            class="min-w-[70px] px-4 py-2 rounded text-white text-center transition
                {{ request('fecha', now()->toDateString()) === $dia->toDateString()
                    ? 'bg-blue-600 border-2 border-blue-300 shadow-lg scale-105'
                    : 'bg-gray-800 hover:bg-blue-600' }}">

            {{ $dia->translatedFormat('D') }}<br>
            {{ $dia->format('d/m') }}

            @if ($dia->isToday())
            <div class="flex items-center justify-center gap-1 text-green-400 font-semibold text-sm mt-1">
                <span class="text-green-400 font-bold">✓</span>
                <span>Hoy</span>
            </div>
            @endif
        </a>
        @endforeach
    </div>

    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold mt-10 mb-4">Lista de clases</h2>

        @forelse ($clasesDisponibles as $clase)

        <div class="p-4 bg-blue shadow rounded mb-3">
            {{ iconoClase($clase->nombreClase) }}
            <strong>{{ $clase->nombreClase }}</strong><br>
            {{ ucfirst($clase->diaDeLaSemana) }} – {{ $clase->hora_inicio }} a {{ $clase->hora_fin }}

            @php
            $ocupadas = $clase->reservas
            ->where('fecha_clase', $fechaSeleccionada)
            ->count();
            //Para detectar si el usuario ya reservó la clase ese día
            $reservaUsuario = $clase->reservas
            ->where('user_id', Auth::id())
            ->where('fecha_clase', $fechaSeleccionada)
            ->first();
            $capacidad = $clase->capacidad_maxima;


            // Detectar si el usuario tiene reserva
            $reservaUsuario = $clase->reservas ->where('user_id', Auth::id())
            ->where('fecha_clase', $fechaSeleccionada)
            ->first();

            $tieneReserva = $reservaUsuario !== null;

            // Fecha de la reserva del usuario
            $fechaReserva = $tieneReserva ? Carbon\Carbon::parse($reservaUsuario->fecha_clase) : null;

            // Fecha seleccionada del carrusel
            try {
            $fechaClase = Carbon\Carbon::parse($fechaSeleccionada);
            } catch (\Exception $e) {
            $fechaClase = null;
            }

            $hoy = Carbon\Carbon::today();
            $manana = $hoy->copy()->addDay();

            // Permitir reservar HOY o MAÑANA
            $puedeReservar = $fechaClase &&
            ($fechaClase->isSameDay($hoy) || $fechaClase->isSameDay($manana));

            // Permitir anular siempre que exista reserva
            $puedeAnular = $tieneReserva;
            @endphp

            <p>
                Capacidad total: {{ $capacidad }} plazas<br>
                Plazas ocupadas: {{ $ocupadas }} / {{ $capacidad }}<br>

            </p>

            {{-- Mensajes --}}
            @if (session('reservado') && session('clase_reservada_id') == $clase->id)
            <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 w-fit mx-auto flex items-center gap-2">
                ✔️ {{ session('reservado') }}
            </div>
            @endif

            @if (session('anulado') && session('clase_anulada_id') == $clase->id)
            <div class="bg-green-500 text-black p-3 rounded mb-4 w-fit mx-auto">
                ❌ {{ session('anulado') }}
            </div>
            @endif

            <!--Mensaje que aparece al usuario cuando reserva dos clases en el mismo dia y se solapan en horarios-->
            @if (session('info') && session('clase_info_id') == $clase->id)
            <div class="bg-red-600 text-white font-semibold p-3 rounded mb-3 w-fit mx-auto">
                ❌ {{ session('info') }}
            </div>
            @endif

            {{-- BOTONES --}}
            @if ($tieneReserva)
            @if ($puedeAnular)
            <form action="{{ route('clases.anular', $clase->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600 transition">
                    Anular
                </button>
            </form>
            @endif
            @else
            @if ($puedeReservar)
            <form action="{{ route('clases.reservar', $clase->id) }}" method="POST">
                @csrf
                <input type="hidden" name="fecha" value="{{ $fechaSeleccionada }}">
                <button class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">
                    Reservar
                </button>
            </form>
            @endif
            @endif
        </div>

        @empty
        <p>No hay clases disponibles.</p>
        @endforelse
    </div>
</x-app-layout>