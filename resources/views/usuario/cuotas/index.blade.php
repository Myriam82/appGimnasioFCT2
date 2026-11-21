<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-semibold mb-6">Mis cuotas</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Pendiente de pago</p>
                <p class="text-2xl font-semibold">{{ number_format($resumen['total_pendiente'], 2, ',', '.') }} €</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Cuotas vencidas</p>
                <p class="text-2xl font-semibold {{ $resumen['vencidas'] ? 'text-red-600' : '' }}">
                    {{ $resumen['vencidas'] }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="p-3">Concepto</th>
                        <th class="p-3">Vencimiento</th>
                        <th class="p-3">Importe</th>
                        <th class="p-3">Pagado</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cuotas as $cuota)
                    <tr class="border-t">
                        <td class="p-3">{{ $cuota->concepto }}</td>
                        <td class="p-3">{{ $cuota->fecha_vencimiento->format('d/m/Y') }}</td>
                        <td class="p-3">{{ number_format($cuota->importe, 2, ',', '.') }} €</td>
                        <td class="p-3">{{ number_format($cuota->pagos_sum_importe ?? 0, 2, ',', '.') }} €</td>
                        <td class="p-3">
                            @if($cuota->estado === \App\Enums\EstadoCuota::Pagada)
                                <span class="text-green-700">Pagada</span>
                            @elseif($cuota->esta_vencida)
                                <span class="text-red-600">Vencida</span>
                            @else
                                <span class="text-amber-600">Pendiente</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <a href="{{ route('usuario.cuotas.show', $cuota) }}" class="text-blue-600">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-gray-500">No tienes cuotas todavía.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $cuotas->links() }}</div>
    </div>
</x-app-layout>