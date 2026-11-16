<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClaseReserva;
use App\Models\Clase;
use Carbon\Carbon;


class ClaseController extends Controller
{

    public function index()
    {
        $hoy = Carbon::now();

        // Primer y último día del mes
        $inicioMes = $hoy->copy()->startOfMonth();
        $finMes = $hoy->copy()->endOfMonth();

        // Día de la semana en que empieza el mes (1 = lunes, 7 = domingo)
        $primerDiaSemana = $inicioMes->dayOfWeekIso;

        // Generar todos los días del mes
        $diasMes = [];
        for ($dia = 1; $dia <= $finMes->day; $dia++) {
            $diasMes[] = $inicioMes->copy()->day($dia);
        }

        // Obtener clases del mes
        $clases = Clase::where('fecha_desde', '<=', $finMes->toDateString())
            ->where('fecha_hasta', '>=', $inicioMes->toDateString())
            ->orderBy('fecha_desde')
            ->orderBy('hora_inicio')
            ->get();

        // Agrupar clases por fecha exacta
        $clasesPorFecha = $clases->groupBy('fecha_desde');

        return view('administrador.dashboard', [
            'diasMes' => $diasMes,
            'primerDiaSemana' => $primerDiaSemana,
            'clasesPorFecha' => $clasesPorFecha,
            'mes' => $hoy->translatedFormat('F Y')
        ]);
    }

    public function create()
    {
        return view('administrador.clases.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Debes iniciar sesión.');
        }
        // Validación básica de los datos de la clase
        $request->validate([
            'nombreClase' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'diaDeLaSemana' => 'required|string|max:255',
            'hora_inicio' => 'nullable',
            'hora_fin' => 'nullable',
            'capacidad_maxima' => 'required|integer|min:1',
            'estado' => 'required|string|max:255',
            'fecha_desde' => 'nullable',
            'fecha_hasta' => 'nullable',
        ]);

        // Creación de la clase en la base de datos
        Clase::create([
            'nombreClase' => $request->nombreClase,
            'categoria' => $request->categoria,
            'diaDeLaSemana' => $request->diaDeLaSemana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'capacidad_maxima' => $request->capacidad_maxima,
            'estado' => $request->estado,
            'user_id' => Auth::id(), // si la clase pertenece al usuario logueado
            'fecha_desde' => $request->fecha_desde,
            'fecha_hasta' => $request->fecha_hasta,

        ]);

        // Redirigir con mensaje
        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }
    //Función que borra desde el administrador una clase concreta
    public function destroy($id)
    {
        //Laravel intenta encontrar la clase en la base de datos
        $clase = Clase::findOrFail($id);
        $clase->delete();
        //Redirige un mensaje con éxito
        return redirect()->route('clases.listado')->with('success', 'Clase eliminada correctamente.');
    }

    public function show(string $id)
    {
        $clase = ClaseReserva::findOrFail($id);
        return view('clases.show', compact('clase'));
    }

    public function update(Request $request, string $id) {}

    public function reservar($id)
    {

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para reservar una clase.');
        }

        // Evitar reservas duplicadas
        $existe = ClaseReserva::where('user_id', $userId)
            ->where('clase_id', $id)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('info', 'Ya tienes esta clase reservada.');
        }

        // Crear la reserva
        ClaseReserva::create([
            'clase_id' => $id,
            'user_id' => $userId,
        ]);
        //Redirige mensaje con éxito
        return redirect()->back()->with('success', 'Clase reservada correctamente.');
    }

    public function listado()
    {
        //El all hace que se obtenga todo el listado de clases de la BD
        $clases = Clase::all();
        //Se envía los datos a la vista
        return view('administrador.clases.listado', compact('clases'));
    }
}
