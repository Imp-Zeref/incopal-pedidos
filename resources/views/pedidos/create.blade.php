<x-layouts.app>
    <x-slot name="title">
        Criar Novo Pedido
    </x-slot>

    <h1 class="text-2xl font-bold mb-6">Criar Novo Pedido</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="POST" action="{{ route('pedidos.store') }}">
            @csrf
            
            {{-- SEÇÃO DE DETALHES DO PEDIDO --}}
            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Detalhes do Pedido</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Selecione um cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                        @if ($errors->has('cliente_id'))
                            <span class="text-red-500 text-sm">{{ $errors->first('cliente_id') }}</span>
                        @endif
                    </select>
            </div>

            {{-- SEÇÃO DE PRODUTOS --}}
            <div x-data="{
                produtos: [ {produto_id: '', quantidade: 1} ],
                adicionarProduto() { this.produtos.push({produto_id: '', quantidade: 1}) },
                removerProduto(index) { this.produtos.splice(index, 1) }
            }" class="mt-8">
                
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Adicionar Produtos (Opcional)</h2>

                <template x-for="(produto, index) in produtos" :key="index">
                    <div class="grid grid-cols-12 gap-4 items-center mb-3 p-2 border rounded">
                        {{-- Dropdown de Produto --}}
                        <div class="col-span-8">
                            <label class="block text-sm font-medium text-gray-700">Produto</label>
                            <select :name="`produtos[${index}][produto_id]`" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Selecione um produto</option>
                                @foreach ($produtosDisponiveis as $produto)
                                    <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Quantidade --}}
                        <div class="col-span-3">
                             <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                            <input type="number" :name="`produtos[${index}][quantidade]`" x-model="produto.quantidade" value="1" step="1" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        {{-- Botão de Remover --}}
                        <div class="col-span-1 pt-6">
                            <button type="button" @click="removerProduto(index)" class="text-red-500 hover:text-red-700 font-bold">&times;</button>
                        </div>
                    </div>
                </template>

                <button type="button" @click="adicionarProduto()" class="mt-2 text-sm text-blue-600 hover:underline">
                    + Adicionar outro produto
                </button>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('pedidos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded-lg mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Criar Pedido
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>