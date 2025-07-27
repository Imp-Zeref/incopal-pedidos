<form wire:submit.prevent="criarPedido">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Criar Novo Pedido</h1>
        <div class="space-x-2">
            <a href="{{ route('pedidos.index') }}"
                class="bg-white hover:bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded-lg border">
                Cancelar
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-transform transform hover:scale-105">
                Salvar Pedido
            </button>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b border-gray-200 pb-3">Informações do Pedido</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="clienteNome" class="block text-sm font-medium text-gray-600 mb-1">Cliente</label>
                <div class="mt-1 flex rounded-lg shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 bg-gray-50 text-gray-500 text-sm">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <input type="text" id="clienteNome" value="{{ $clienteNome }}" readonly
                        class="flex-1 block w-full rounded-none bg-gray-100 border pl-5 border-gray-300 text-gray-700 focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" wire:click="openClienteSearchModal"
                        class="px-3 py-2 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100">Pesquisar</button>
                </div>
            </div>
            <div>
                <label for="tipoPedidoId" class="block text-sm font-medium text-gray-600 mb-1">Tipo de Pedido</label>
                <select id="tipoPedidoId" wire:model="tipoPedidoId"
                    class="mt-1 block w-full border p-2 border-gray-300 rounded-lg shadow-sm">
                    <option value="">Selecione...</option>
                    @foreach ($tiposPedido as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                    @endforeach
                </select>
                @error('tipoPedidoId')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="dtPrevisao" class="block text-sm font-medium text-gray-600 mb-1">Data de Previsão</label>
                <input type="date" id="dtPrevisao" wire:model="dtPrevisao"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 border">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div class="md:col-span-2">
                <label for="observacao" class="block text-sm font-medium text-gray-600 mb-1">Observações</label>
                <textarea id="observacao" wire:model="observacao"
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm p-2 border resize-y" rows="3"
                    placeholder="Digite observações adicionais aqui..."></textarea>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-lg overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <button type="button" wire:click="openProductSearchModal"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg flex items-center space-x-2">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Pesquisar Produto</span>
            </button>
        </div>
        @error('orderItems')
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                <p>{{ $message }}</p>
            </div>
        @enderror
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/4">
                            Código</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/4">
                            Descrição</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/4">
                            Original</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-2/4">
                            Secundário</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-1/4">
                            Quantidade</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider w-auto">
                            Ação</th>
                    </tr>
                </thead>
                <tbody class="bg-white font-semibold text-sm">
                    @forelse($orderItems as $index => $item)
                        <tr wire:key="order-item-{{ $index }}"
                            class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition-colors duration-200">
                            <td class="p-3 align-top w-1/12">
                                <input type="text" wire:model.lazy="orderItems.{{ $index }}.codigo"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 shadow-sm text-xs uppercase focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    placeholder="Código">
                                @error('orderItems.' . $index . '.codigo')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="px-4 py-3 text-gray-800 align-middle">{{ $item['descricao'] }}</td>
                            <td class="px-4 py-3 text-gray-700 align-middle">{{ $item['original'] }}</td>
                            <td class="px-4 py-3 text-gray-700 align-middle">{{ $item['secundario'] }}</td>
                            <td class="p-3 align-top w-1/12">
                                <input type="number" wire:model="orderItems.{{ $index }}.quantidade"
                                    class="w-24 border border-gray-300 rounded-lg px-3 py-2 shadow-sm text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"
                                    min="1">
                                @error('orderItems.' . $index . '.quantidade')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="px-4 py-3 text-center align-middle">
                                <button type="button" wire:click="removeOrderItem({{ $index }})"
                                    class="text-red-500 hover:text-red-700 p-1 rounded-full transition hover:bg-red-100"
                                    title="Remover item">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-500">
                                <p class="font-medium">Nenhum produto adicionado.</p>
                                <p class="text-sm">Use a busca ou digite o código do produto para começar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($showClienteSearchModal)
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center px-4 sm:px-0">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 sm:p-8 animate-fade-in relative">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">🔍 Buscar Cliente</h2>
                <input type="text" wire:model.live.debounce.300ms="clienteSearch"
                    placeholder="Digite o nome do cliente..." autofocus
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                <ul class="max-h-64 overflow-y-auto divide-y divide-gray-100 border rounded-md text-sm text-black">
                    @forelse($clienteResults as $cliente)
                        <li wire:click="selectCliente({{ $cliente->id }}, '{{ addslashes($cliente->nome) }}')"
                            class="cursor-pointer text-gray-800 hover:bg-blue-100 px-4 py-2">
                            {{ $cliente->nome }}
                        </li>
                    @empty
                        <li class="px-4 py-4 text-center text-gray-500">
                            Nenhum cliente encontrado.
                        </li>
                    @endforelse
                </ul>
                <div class="mt-6 flex justify-between items-center">
                    <button type="button" wire:click="clearCliente"
                        class="text-sm text-gray-600 hover:text-gray-800 underline transition">
                        Limpar Seleção
                    </button>

                    <button type="button" wire:click="closeClienteSearchModal"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 text-sm rounded-md transition">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    @endif
    @if ($showProductSearchModal)
        <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center px-4 sm:px-0">
            <div
                class="bg-white rounded-xl shadow-2xl w-full max-w-6xl max-h-[85vh] flex flex-col p-6 animate-fade-in">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">📦 Buscar Produto</h2>
                    <button type="button" wire:click="closeProductSearchModal"
                        class="text-gray-500 hover:text-gray-800 focus:outline-none">
                        ✕
                    </button>
                </div>
                <div
                    class="flex flex-col sm:flex-row bg-gray-50 p-3 rounded-lg space-y-3 sm:space-y-0 sm:space-x-6 shadow-inner mb-4">
                    <input wire:model.live.debounce.300ms="produtoSearch" type="text"
                        placeholder="Pesquisar por código, nome, descrição, aplicação..."
                        class="flex-1 bg-gray-100 border border-gray-300 rounded-lg py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <label class="inline-flex items-center space-x-2 text-sm text-gray-700">
                        <input type="checkbox" wire:model.live="useCommaAsAnd" class="form-checkbox text-blue-600">
                        <span>Buscar termos separados por vírgula</span>
                    </label>
                </div>
                <div class="overflow-y-auto border rounded-lg flex-grow min-h-[40vh]">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 sticky top-0 z-10 text-xs uppercase text-gray-600">
                            <tr>
                                <th class="px-3 py-2 text-left">Código</th>
                                <th class="px-3 py-2 text-left">Original</th>
                                <th class="px-3 py-2 text-left">Descrição</th>
                                <th class="px-3 py-2 text-left">Descrição2</th>
                                <th class="px-3 py-2 text-left">Secundário</th>
                                <th class="px-3 py-2 text-left">Local</th>
                                <th class="px-3 py-2 text-left">Preço</th>
                                <th class="px-3 py-2 text-left">Estoque</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium">
                            @forelse($produtoResults as $product)
                                <tr wire:key="search-result-{{ $product->id }}"
                                    class="hover:bg-blue-100 cursor-pointer transition"
                                    wire:click="selectProduct('{{ $product->codigo }}')">
                                    <td class="px-3 py-2 font-mono text-blue-900">{{ $product->codigo }}</td>
                                    <td class="px-3 py-2">{{ $product->original ?? '' }}</td>
                                    <td class="px-3 py-2">{{ $product->descricao ?? '' }}</td>
                                    <td class="px-3 py-2">{{ $product->descricao2 ?? '' }}</td>
                                    <td class="px-3 py-2">{{ $product->secundario ?? '' }}</td>
                                    <td class="px-3 py-2">{{ $product->localizacao ?? '' }}</td>
                                    <td class="px-3 py-2 text-green-600">R$
                                        {{ number_format($product->preco ?? 0, 2, ',', '.') }}</td>
                                    <td class="px-3 py-2">{{ $product->estoque ?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-10 text-center text-gray-500">
                                        Nenhum produto encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-right">
                    <button type="button" wire:click="closeProductSearchModal"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md transition">Fechar</button>
                </div>
            </div>
        </div>
    @endif
</form>
