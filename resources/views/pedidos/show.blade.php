<x-layouts.app>
    <x-slot name="title">
        Detalhes do Pedido #{{ $pedido->id }}
    </x-slot>

    <div>
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('pedidos.index') }}" class="text-blue-600 hover:underline font-semibold flex items-center space-x-2">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                <span>Voltar para a lista</span>
            </a>
        </div>

        {{-- PAINEL DE DETALHES DO PEDIDO --}}
        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detalhes do Pedido #{{ $pedido->id }}</h2>
                    <p class="text-sm text-gray-500">Criado por: {{ $pedido->usuario->nome }} em {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="font-semibold text-gray-500 block text-sm">Status</span>
                    <span class="text-base text-white font-bold px-3 py-1 rounded-full
                        @switch($pedido->statusPedido->nome)
                            @case('Pendente') bg-yellow-500 @break
                            @case('Encomendado') bg-blue-500 @break
                            @case('Concluído') bg-green-500 @break
                            @case('Cancelado') bg-red-500 @break
                            @default bg-gray-500
                        @endswitch">
                        {{ $pedido->statusPedido->nome }}
                    </span>
                </div>
            </div>

            <dl class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-4 text-sm">
                <div>
                    <dt class="font-semibold text-gray-500">Cliente</dt>
                    <dd class="mt-1 text-gray-900 font-medium text-base">{{ $pedido->cliente->nome ?? 'Nenhum' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-500">Tipo de Pedido</dt>
                    <dd class="mt-1 text-gray-900 font-medium text-base">{{ $pedido->tipoPedido->nome }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-500">Previsão de Entrega</dt>
                    <dd class="mt-1 text-gray-900 font-medium text-base">{{ $pedido->dt_previsao ? $pedido->dt_previsao->format('d/m/Y') : 'Não definida' }}</dd>
                </div>
                <div class="md:col-span-3">
                    <dt class="font-semibold text-gray-500">Observação</dt>
                    <dd class="mt-1 text-base bg-gray-50 p-3 rounded-md text-gray-800 border">{{ $pedido->observacao ?? 'Nenhuma observação.' }}</dd>
                </div>
            </dl>
        </div>
        
        {{-- PAINEL DE AÇÕES DO ADMINISTRADOR --}}
        @can('changeStatus', $pedido)
            <div class="mb-8 bg-yellow-50 border border-yellow-200 p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold mb-4 text-yellow-800">Ações do Administrador</h2>
                <form method="POST" action="{{ route('pedidos.status.update', $pedido) }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex items-center space-x-4">
                        <label for="fk_status_pedido" class="font-medium text-gray-700">Alterar Status para:</label>
                        <select id="fk_status_pedido" name="fk_status_pedido" class="border p-2 border-gray-300 rounded-lg shadow-sm">
                            @foreach ($statusDisponiveis as $status)
                                <option value="{{ $status->id }}">{{ $status->nome }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg">
                            Atualizar Status
                        </button>
                    </div>
                </form>
            </div>
        @endcan

        {{-- PAINEL DE PRODUTOS --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <div class="flex justify-between items-center mb-4">
                 <h2 class="text-2xl font-bold text-gray-800">Produtos do Pedido</h2>
                 @can('addProduct', $pedido)
                    <button data-modal-toggle="add-product-modal" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Adicionar Produto</button>
                 @endcan
            </div>
           
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-bold uppercase text-gray-600">Produto</th>
                            <th class="px-4 py-3 text-left font-bold uppercase text-gray-600">Quantidade</th>
                            <th class="px-4 py-3 text-left font-bold uppercase text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pedido->produtos as $produto)
                            <tr class="hover:bg-blue-50">
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    <span class="font-mono text-xs text-gray-500 block">{{ $produto->codigo }}</span>
                                    {{ $produto->descricao }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $produto->pivot->quantidade }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $produto->pivot->statusProduto->nome ?? 'Pendente' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-10 text-center text-gray-500">
                                    Nenhum produto foi adicionado a este pedido ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- AÇÃO DE CANCELAR --}}
        @can('cancel', $pedido)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-xl font-bold mb-2 text-red-700">Cancelar Pedido</h3>
                <p class="text-sm text-gray-600 mb-4">Esta ação não pode ser desfeita. O status do pedido será alterado para "Cancelado".</p>
                <form method="POST" action="{{ route('pedidos.cancel', $pedido) }}" onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                        Confirmar Cancelamento
                    </button>
                </form>
            </div>
        @endcan
    </div>

    {{-- MODAL PARA ADICIONAR PRODUTO --}}
    @can('addProduct', $pedido)
    <div id="add-product-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5">
                    <h3 class="text-xl font-semibold text-gray-900">Adicionar Novo Produto</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-toggle="add-product-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Fechar modal</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('pedidos.produtos.store', $pedido->id) }}">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="produto_id" class="block mb-2 text-sm font-medium text-gray-900">Produto</label>
                            <select id="produto_id" name="produto_id" required class="w-full border p-2 border-gray-300 rounded-lg shadow-sm">
                                <option value="">Selecione um produto</option>
                                @foreach ($produtosDisponiveis as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->codigo }} - {{ $produto->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="quantidade" class="block mb-2 text-sm font-medium text-gray-900">Quantidade</label>
                            <input type="number" name="quantidade" id="quantidade" value="1" step="1" min="1" required class="w-full border p-2 border-gray-300 rounded-lg shadow-sm">
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        Adicionar Produto
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endcan
</x-layouts.app>