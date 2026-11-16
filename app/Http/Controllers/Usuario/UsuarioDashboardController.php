<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use Illuminate\Support\Facades\Auth;

use App\Models\ClaseReserva;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;



use Carbon\Carbon;

class UsuarioDashboardController extends Controller
{

    public function index(Request $request)
    {
        // Si no hay fecha seleccionada, usar hoy
        $fechaSeleccionada = $request->input('fecha', Carbon::now()->toDateString());

        $hoy = Carbon::now();

        // Inicio de la semana (lunes)
        $inicioSemana = $hoy->copy()->startOfWeek(Carbon::MONDAY);

        // Generar los 7 días de la semana
        $diasSemana = [];
        for ($i = 0; $i < 7; $i++) {
            $diasSemana[] = $inicioSemana->copy()->addDays($i);
        }
        // Día de la semana en texto (lunes, martes…)
        $diaSemana = Carbon::parse($fechaSeleccionada)->locale('es')->dayName;

        // Obtener clases activas ese día
        $clasesDisponibles = Clase::where('fecha_desde', '<=', $fechaSeleccionada)
            ->where('fecha_hasta', '>=', $fechaSeleccionada)
            ->where('diaDeLaSemana', $diaSemana)
            ->orderBy('hora_inicio')
            ->get();

        return view('usuario.dashboard', [
            'diasSemana' => $diasSemana,
            'clasesDisponibles' => $clasesDisponibles

        ]);
    }
    public function reservaClases(Request $request)
    {
        // Fecha seleccionada o hoy por defecto
        $fechaSeleccionada = $request->input('fecha', Carbon::today()->toDateString());
        $fechaCarbon = Carbon::parse($fechaSeleccionada);

        // 🔵 CARRUSEL DE 15 DÍAS (incluye domingos)
        $diasCarrusel = [];
        $hoy = Carbon::today();

        for ($i = 0; $i < 15; $i++) {
            $diasCarrusel[] = $hoy->copy()->addDays($i);
        }

        // 🔴 Si es domingo → no hay clases
        if ($fechaCarbon->isSunday()) {
            $clasesDisponibles = collect(); // lista vacía
        } else {
            $clasesDisponibles = Clase::where('diaDeLaSemana', $fechaCarbon->dayName)->get();
        }

        return view('usuario.reservaClases', compact('diasCarrusel', 'clasesDisponibles', 'fechaSeleccionada'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => ['nullable', 'string'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'rol' =>  $request->rol,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'dni' => $request->dni,
            'password' => Hash::make($request->password),
            // 'rol' => User::ROLE_USUARIO,
            'rol' => $request->role
        ]);
        event(new Registered($user));
        Auth::login($user);
        if ($user->rol === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }

    // Elimina la reserva del usuario autenticado para esa clase 
    public function anular(Request $request, $id)
    {
        $user = Auth::user();

        // Buscar la reserva del usuario para esta clase
        $reserva = ClaseReserva::where('user_id', $user->id)
            ->where('clase_id', $id)
            ->first();

        if (!$reserva) {
            return back()->with([
                'info' => 'No tienes una reserva para esta clase.',
                'clase_info_id' => $id
            ]);
        }

        // Fechas importantes
        $hoy = Carbon::today();
        $manana = $hoy->copy()->addDay();
        $fechaReserva = Carbon::parse($reserva->fecha_clase);

        // Solo permitir anular HOY o MAÑANA
        if (!($fechaReserva->isSameDay($hoy) || $fechaReserva->isSameDay($manana))) {
            return back()->with([
                'info' => 'Solo puedes anular reservas de hoy o mañana.',
                'clase_info_id' => $id
            ]);
        }

        // Eliminar la reserva
        $reserva->delete();

        return back()->with([
            'success' => 'Reserva anulada correctamente.',
            'clase_info_id' => $id
        ]);
    }

    /* public function reservar($id)
    {

        ClaseReserva::create([
            'user_id' => Auth::id(),
            'clase_id' => $id,
        ]);
        return back()
            ->with('reservado', '¡Reserva realizada correctamente!');
        //'success', 'Clase reservada correctamente.'
    }*/
    public function reservar($id, Request $request)
    {
        $clase = Clase::findOrFail($id);

        // Fecha seleccionada por el usuario
        $fechaSeleccionada = $request->input('fecha');
        $fechaSeleccionadaCarbon = Carbon::parse($fechaSeleccionada);

        // ❌ Bloquear domingos
        if ($fechaSeleccionadaCarbon->isSunday()) {
            return back()->with([
                'info' => 'No hay clases disponibles los domingos.',
                'clase_info_id' => $id
            ]);
        }

        // ❌ No permitir reservar días pasados
        if ($fechaSeleccionadaCarbon->isBefore(today())) {
            return back()->with([
                'info' => 'No puedes reservar una clase en una fecha que ya ha pasado.',
                'clase_info_id' => $id
            ]);
        }

        // Hora completa de la clase
        $horaClase = Carbon::parse($fechaSeleccionadaCarbon->toDateString() . ' ' . $clase->hora_inicio);

        // ❌ No permitir reservar si la clase ya empezó
        if (now()->greaterThanOrEqualTo($horaClase)) {
            return back()->with([
                'info' => 'No puedes reservar una clase que ya ha comenzado.',
                'clase_info_id' => $id
            ]);
        }
        // ❌ Comprobar solapamiento de horarios
        $solapamiento = ClaseReserva::where('user_id', Auth::id())
            ->whereDate('fecha_clase', $fechaSeleccionadaCarbon->toDateString())
            ->whereHas('clase', function ($query) use ($clase) {
                $query->where('hora_inicio', '<', $clase->hora_fin)
                    ->where('hora_fin', '>', $clase->hora_inicio);
            })
            ->exists();

        if ($solapamiento) {
            return back()->with([
                'info' => 'No puedes reservar esta clase porque se solapa con otra que ya tienes reservada.',
                'clase_info_id' => $id
            ]);
        }
        // ❌ Bloquear si el usuario ya tiene 2 reservas activas (hoy o futuras)
        $reservasActivas = ClaseReserva::where('user_id', Auth::id())
            ->whereDate('fecha_clase', '>=', today()) // cuenta hoy y días futuros
            ->count();

        if ($reservasActivas >= 2) {
            return back()->with([
                'info' => 'Ya tienes el máximo de 2 clases activas (entre hoy y los próximos días). Espera a que termine alguna para reservar más.',
                'clase_info_id' => $id
            ]);
        }

        // Límite de 2 reservas por día
        // Contar reservas del usuario SOLO para ese día exacto
        $reservasDelDia = ClaseReserva::where('user_id', Auth::id())
            ->whereDate('fecha_clase', $fechaSeleccionadaCarbon->toDateString())
            ->count();

        if ($reservasDelDia >= 2) {
            return back()->with([
                'info' => 'Solo puedes reservar un máximo de 2 clases por día.',
                'clase_info_id' => $id
            ]);
        }


        // Crear la reserva
        ClaseReserva::create([
            'user_id' => Auth::id(),
            'clase_id' => $clase->id,
            'fecha_clase' => $fechaSeleccionadaCarbon->toDateString(),
        ]);

        return back()->with([
            'reservado' => 'Tienes una reserva.',
            'clase_reservada_id' => $clase->id
        ]);
    }

    public function mostrarClases(Request $request)
    {
        // Fecha seleccionada (por defecto hoy)
        $fechaSeleccionada = $request->input('fecha', now()->toDateString());
        $fechaCarbon = Carbon::parse($fechaSeleccionada);

        // Carrusel continuo: próximos 60 días
        $hoy = Carbon::today();
        $diasCarrusel = [];

        for ($i = 0; $i < 15; $i++) {
            $diasCarrusel[] = $hoy->copy()->addDays($i);
        }

        // Normalizar día de la semana (sin acentos)
        $diaEs = strtolower($fechaCarbon->locale('es')->dayName);
        $diaEs = str_replace(
            ['á', 'é', 'í', 'ó', 'ú'],
            ['a',  'e',  'i',  'o',  'u'],
            $diaEs
        );

        // Clases activas ese día
        $clasesDisponibles = Clase::where('fecha_desde', '<=', $fechaSeleccionada)
            ->where('fecha_hasta', '>=', $fechaSeleccionada)
            ->where('diaDeLaSemana', $diaEs)
            ->orderBy('hora_inicio')
            ->get();

        return view('usuario.reservaClases', [
            'diasCarrusel'      => $diasCarrusel,
            'clasesDisponibles' => $clasesDisponibles,
            'fechaSeleccionada' => $fechaSeleccionada,
        ]);
    }
}
