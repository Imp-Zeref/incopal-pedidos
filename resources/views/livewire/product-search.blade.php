<div>
    {{-- BARRA DE FILTROS E PESQUISA --}}
    <div class="bg-white p-4 rounded-xl shadow-lg mb-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 items-center">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar por produtos..."
                class="w-full border-gray-300 rounded-lg shadow-sm py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

            <div class="flex items-center space-x-4 justify-start md:justify-end">
                <label class="flex items-center text-sm cursor-pointer">
                    <input type="checkbox" wire:model.live="matchAllWords" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                    <span class="ml-2 text-gray-700">Combinar palavras</span>
                </label>
                <button wire:click="clearFilters" class="text-sm text-blue-600 hover:underline font-medium">Limpar Filtros</button>
            </div>
        </div>

        <div>
            <h4 class="font-semibold text-gray-600 mb-2 text-sm">Buscar em:</h4>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <label class="inline-flex items-center font-bold cursor-pointer">
                    <input type="checkbox" wire:model.live="searchAllColumns" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                    <span class="ml-2">Todas</span>
                </label>
                @foreach ($availableColumns as $key => $label)
                <label class="inline-flex items-center cursor-pointer" :class="{ 'opacity-50 cursor-not-allowed': $wire.searchAllColumns }">
                    <input type="checkbox" wire:model.live="selectedColumns" value="{{ $key }}"
                        :disabled="$wire.searchAllColumns"
                        class="form-checkbox h-5 w-5 text-gray-500 rounded">
                    <span class="ml-2">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>
    </div>

    {{-- TABELA DE PRODUTOS --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm table-fixed">
                <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-2 bg-gray-100">Código</th>
                        <th class="px-4 py-2 bg-gray-100">Original</th>
                        <th class="px-4 py-2 bg-gray-100">Descrição</th>
                        <th class="px-4 py-2 bg-gray-100">Descrição2</th>
                        <th class="px-4 py-2 bg-gray-100">Secundário</th>
                        <th class="px-4 py-2 bg-gray-100">Localização</th>
                        <th class="px-4 py-2 bg-gray-100">Diversa</th>
                        <th class="px-4 py-2 bg-gray-100">Aplicação</th>
                        <th class="px-4 py-2 bg-gray-100">Descrição3</th>
                    </tr>
                </thead>
            </table>

            {{-- Área rolável do body --}}
            <div class="max-h-[400px] overflow-y-auto">
                <table class="min-w-full text-sm table-fixed">
                    <tbody class="divide-y divide-gray-200 text-gray-700">
                        @forelse ($produtos as $produto)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="px-4 py-2">{{ $produto->codigo }}</td>
                            <td class="px-4 py-2">{{ $produto->original ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->descricao ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->descricao2 ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->secundario ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->localizacao ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->diversa ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->aplicacao ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->descricao3 ?? '' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center px-4 py-6 text-gray-500">
                                Nenhum produto encontrado com os filtros atuais.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TRIGGER DO SCROLL INFINITO --}}
    <div x-data="{}" x-intersect.full.threshold.1="$wire.loadMore()" class="text-center py-6">
        <div wire:loading wire:target="loadMore">
            <p class="text-gray-500 animate-pulse">Carregando mais...</p>
        </div>
    </div>
</div>