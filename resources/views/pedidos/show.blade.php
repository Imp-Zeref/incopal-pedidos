<x-layouts.app>
    <x-slot name="title">
        Detalhes do Pedido #{{ $pedido->id }}
    </x-slot>

    <div>
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('pedidos.index') }}" class="text-blue-600 hover:underline">
                &larr; Voltar para a lista de pedidos
            </a>
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
        
        @if (auth()->user()->tipoUsuario->nome === 'Administrador')
        <div class="mb-8 bg-yellow-50 border border-yellow-200 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-yellow-800">Ações do Administrador</h2>
            <form method="POST" action="{{ route('pedidos.status.update', $pedido) }}">
                @csrf
                @method('PATCH')
                <div class="flex items-center space-x-4">
                    <label for="fk_status_pedido" class="font-semibold">Alterar Status para:</label>
                    <select id="fk_status_pedido" name="fk_status_pedido" class="py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach ($statusDisponiveis as $status)
                        <option value="{{ $status->id }}" @if($pedido->fk_status_pedido == $status->id) selected @endif>
                            {{ $status->nome }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg">
                        Atualizar Status
                    </button>
                </div>
            </form>
        </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Produtos do Pedido</h2>
            
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner mb-6">
                <h3 class="text-xl font-bold mb-4">Adicionar Novo Produto</h3>
                <form method="POST" action="{{ route('pedidos.produtos.store', $pedido->id) }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label for="produto_id" class="block text-sm font-medium text-gray-700">Produto</label>
                            <select id="produto_id" name="produto_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Selecione um produto</option>
                                @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade</label>
                            <input type="number" name="quantidade" id="quantidade" value="1" step="0.01" required class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                            Adicionar Produto
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="py-2 px-4 text-left">Produto</th>
                            <th class="py-2 px-4 text-left">Quantidade</th>
                            <th class="py-2 px-4 text-left">Custo Unitário</th>
                            <th class="py-2 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedido->produtos as $produto)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="py-3 px-4">{{ $produto->nome }}</td>
                            <td class="py-3 px-4">{{ $produto->pivot->quantidade }}</td>
                            <td class="py-3 px-4">
                                @if($produto->pivot->custo)
                                    R$ {{ number_format($produto->pivot->custo, 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $produto->pivot->statusProduto->nome ?? 'Pendente' }}</td>
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

        @if (auth()->id() === $pedido->fk_usuario && $pedido->statusPedido->nome === 'Pendente')
        <div class="mt-8 border-t pt-6">
            <h3 class="text-xl font-bold mb-4 text-red-700">Ações do Pedido</h3>
            <form method="POST" action="{{ route('pedidos.cancel', $pedido) }}" onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                    Cancelar Pedido
                </button>
            </form>
        </div>
        @endif

    </div>
</x-layouts.app>