<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-semibold mb-6">Mis pagos</h1>

        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="p-3">Fecha</th>
                        <th class="p-3">Concepto</th>
                        <th class="p-3">Método</th>
                        <th class="p-3">Importe</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pagos as $pago)
                    <tr class="border-t">
                        <td class="p-3">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="p-3">{{ $pago->cuota->concepto }}</td>
                        <td class="p-3">{{ ucfirst($pago->metodo) }}</td>
                        <td class="p-3">{{ number_format($pago->importe, 2, ',', '.') }} €</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">Todavía no tienes pagos registrados.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $pagos->links() }}</div>
    </div>
</x-app-layout>