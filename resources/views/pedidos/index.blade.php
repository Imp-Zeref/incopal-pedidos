<x-layouts.app>
    <x-slot name="title">
        Meus Pedidos
    </x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Meus Pedidos</h1>
        <a href="{{ route('pedidos.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            Novo Pedido
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="border-b">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-600 font-semibold">ID</th>
                        <th class="py-3 px-4 text-left text-gray-600 font-semibold">Cliente</th>
                        <th class="py-3 px-4 text-left text-gray-600 font-semibold">Tipo</th>
                        <th class="py-3 px-4 text-left text-gray-600 font-semibold">Status</th>
                        <th class="py-3 px-4 text-left text-gray-600 font-semibold">Data</th>
                        <th class="py-3 px-4 text-left text-gray-600 font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="py-3 px-4">{{ $pedido->id }}</td>
                            <td class="py-3 px-4">{{ $pedido->cliente->nome ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $pedido->tipoPedido->nome ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $pedido->statusPedido->nome ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $pedido->created_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('pedidos.show', $pedido->id) }}"
                                    class="text-blue-600 hover:underline">Ver Detalhes</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">Nenhum pedido encontrado.
                            </td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>


    </div>
</x-layouts.app>
