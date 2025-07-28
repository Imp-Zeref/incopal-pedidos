<x-layouts.app>
    <x-slot name="title">Anotação: {{ $blocoNota->titulo }}</x-slot>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <form action="{{ route('bloco-notas.update', $blocoNota) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-4">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-gray-600 mb-1">Título</label>
                            <input type="text" name="titulo" id="titulo" value="{{ $blocoNota->titulo }}" class=" p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label for="nome_cliente" class="block text-sm font-medium text-gray-600 mb-1">Nome do Cliente</label>
                            <input type="text" name="nome_cliente" id="nome_cliente" value="{{ $blocoNota->nome_cliente }}" class=" p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label for="anotacoes" class="block text-sm font-medium text-gray-600 mb-1">Anotações</label>
                            <textarea name="anotacoes" id="anotacoes" rows="4" class=" p-2 border w-full border-gray-300 rounded-lg shadow-sm">{{ $blocoNota->anotacoes }}</textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Salvar Alterações</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Produtos na Anotação</h2>
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left ">Produto</th>
                                <th class="px-4 py-2 text-left">Quantidade</th>
                                <th class="px-4 py-2 text-left">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($blocoNota->produtos as $produto)
                                <tr>
                                    <td class="px-4 py-2">{{ $produto->codigo }} - {{ $produto->descricao }}</td>
                                    <td class="px-4 py-2">{{ $produto->pivot->quantidade }}</td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('bloco_notas.produtos.remove', [$blocoNota, $produto]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Nenhum produto.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Adicionar Produto</h2>
            <form action="{{ route('bloco_notas.produtos.add', $blocoNota) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="produto_id" class="block text-sm font-medium text-gray-600 mb-1">Produto</label>
                        <select name="produto_id" id="produto_id" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                            @foreach($produtosDisponiveis as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->codigo }} - {{ $produto->descricao }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="quantidade" class="block text-sm font-medium text-gray-600 mb-1">Quantidade</label>
                        <input type="number" name="quantidade" id="quantidade" value="1" min="1" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg">Adicionar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>