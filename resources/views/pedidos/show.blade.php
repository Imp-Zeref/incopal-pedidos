<x-layouts.app>
    <x-slot name="title">
        Detalhes do Pedido #{{ $pedido->id }}
    </x-slot>

    <div>
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('pedidos.index') }}" class="text-blue-600 hover:underline">
                &larr; Voltar para a lista de pedidos
            </a>
            
            {{-- Futuro botão de editar --}}
            {{-- <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">Editar Pedido</a> --}}
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-bold mb-4">Detalhes do Pedido #{{ $pedido->id }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="font-semibold text-gray-600">Status:</span>
                    <p class="text-lg">{{ $pedido->statusPedido->nome }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Tipo:</span>
                    <p class="text-lg">{{ $pedido->tipoPedido->nome }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Cliente:</span>
                    <p class="text-lg">{{ $pedido->cliente->nome ?? 'Nenhum' }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Criado por:</span>
                    <p class="text-lg">{{ $pedido->usuario->nome }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Data de Criação:</span>
                    <p class="text-lg">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <span class="font-semibold text-gray-600">Previsão de Entrega:</span>
                    <p class="text-lg">{{ $pedido->dt_previsao ? $pedido->dt_previsao->format('d/m/Y') : 'Não definida' }}</p>
                </div>
                <div class="md:col-span-3">
                    <span class="font-semibold text-gray-600">Observação:</span>
                    <p class="text-lg bg-gray-50 p-3 rounded-md mt-1">{{ $pedido->observacao ?? 'Nenhuma observação.' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Produtos do Pedido</h2>
                {{-- Futuro botão de adicionar produtos --}}
                {{-- <a href="#" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">Adicionar Produto</a> --}}
            </div>

            {{-- Tabela de Produtos --}}
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2 px-4 text-left">Produto</th>
                            <th class="py-2 px-4 text-left">Quantidade</th>
                            <th class="py-2 px-4 text-left">Custo</th>
                            <th class="py-2 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedido->produtos as $produto)
                            <tr class="hover:bg-gray-50 border-b">
                                <td class="py-3 px-4">{{ $produto->nome }}</td>
                                <td class="py-3 px-4">{{ $produto->pivot->quantidade }}</td>
                                <td class="py-3 px-4">R$ {{ number_format($produto->pivot->custo, 2, ',', '.') }}</td>
                                <td class="py-3 px-4">{{-- Status do produto --}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">
                                    Nenhum produto foi adicionado a este pedido ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        </div>
</x-layouts.app>