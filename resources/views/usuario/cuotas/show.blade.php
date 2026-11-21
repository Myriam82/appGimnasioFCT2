<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <a href="{{ route('usuario.cuotas.index') }}" class="text-blue-600 text-sm">← Volver a mis cuotas</a>

        <h1 class="text-2xl font-semibold mt-3 mb-6">{{ $cuota->concepto }}</h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Importe</p>
                <p class="text-xl font-semibold">{{ number_format($cuota->importe, 2, ',', '.') }} €</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Pagado</p>
                <p class="text-xl font-semibold">{{ number_format($cuota->total_pagado, 2, ',', '.') }} €</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-gray-500 text-sm">Pendiente</p>
                <p class="text-xl font-semibold">{{ number_format($cuota->pendiente, 2, ',', '.') }} €</p>
            </div>
        </div>

        <p class="text-sm text-gray-600 mb-4">
            Vencimiento: {{ $cuota->fecha_vencimiento->format('d/m/Y') }}
            @if($cuota->esta_vencida)
                <span class="text-red-600 font-medium">(vencida)</span>
            @endif
        </p>

        <h2 class="text-lg font-semibold mb-3">Pagos realizados</h2>
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="p-3">Fecha</th>
                        <th class="p-3">Método</th>
                        <th class="p-3">Importe</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($cuota->pagos as $pago)
                    <tr class="border-t">
                        <td class="p-3">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="p-3">{{ ucfirst($pago->metodo) }}</td>
                        <td class="p-3">{{ number_format($pago->importe, 2, ',', '.') }} €</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-6 text-center text-gray-500">Sin pagos todavía.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>