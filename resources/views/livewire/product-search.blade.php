<div>
    {{-- BARRA DE FILTROS E PESQUISA --}}
    <div class="bg-white p-4 rounded-xl shadow-lg mb-2">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar por código, nome, descrição, aplicação..."
            class="w-full border-gray-300 rounded-lg shadow-sm py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <div class="flex items-center space-x-4 mt-2">
            <label class="flex items-center">
                <input type="checkbox" wire:model.live="useCommaAsAnd" class="form-checkbox h-5 w-5 text-indigo-600">
                <span class="ml-2 text-gray-700">Buscar termos separados por vírgula</span>
            </label>
        </div>
    </div>

    {{-- TABELA DE PRODUTOS CORRIGIDA --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- A div externa controla o scroll e a altura máxima --}}
        <div class="overflow-y-auto" style="max-height: 75vh;">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Código</th>
                        <th class="px-4 py-3 w-2/12 text-left font-bold uppercase tracking-wider">Original</th>
                        <th class="px-4 py-3 w-3/12 text-left font-bold uppercase tracking-wider">Descrição</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Descrição2</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Secundário</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Localização</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Diversa</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Aplicação</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Descrição3</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700" wire:loading.class.delay="opacity-50">
                    @forelse ($produtos as $produto)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-4 py-2 font-mono">{{ $produto->codigo }}</td>
                        <td class="px-4 py-2">{{ $produto->original ?? '' }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $produto->descricao ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->descricao2 ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->secundario ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->localizacao ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->diversa ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->aplicacao ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->descricao3 ?? '' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center px-4 py-16 text-gray-500">
                            Nenhum produto encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- TRIGGER DO SCROLL INFINITO - POSIÇÃO CORRIGIDA --}}
            <div x-data x-intersect.full="$wire.loadMore()">
                <div wire:loading wire:target="loadMore" class="text-center py-6">
                    <p class="text-gray-500 animate-pulse">Carregando mais...</p>
                </div>
            </div>
        </div>
    </div>
</div>