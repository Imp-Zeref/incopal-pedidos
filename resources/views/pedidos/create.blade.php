<x-layouts.app>
    <x-slot name="title">
        Criar Novo Pedido
    </x-slot>

    <h1 class="text-2xl font-bold mb-6">Criar Novo Pedido</h1>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <form method="POST" action="{{ route('pedidos.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="fk_cliente" class="block text-sm font-medium text-gray-700">Cliente (Opcional)</label>
                    <select id="fk_cliente" name="fk_cliente" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Nenhum</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="fk_tipo_pedido" class="block text-sm font-medium text-gray-700">Tipo de Pedido</label>
                    <select id="fk_tipo_pedido" name="fk_tipo_pedido" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @foreach ($tiposPedido as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="dt_previsao" class="block text-sm font-medium text-gray-700">Data de Previsão</label>
                    <input type="date" name="dt_previsao" id="dt_previsao" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="md:col-span-2">
                    <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
                    <textarea name="observacao" id="observacao" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input id="urgente" name="urgente" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="urgente" class="ml-2 block text-sm text-gray-900">Marcar como Urgente</label>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('pedidos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-black font-bold py-2 px-4 rounded-lg mr-2">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Salvar e Adicionar Produtos
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>