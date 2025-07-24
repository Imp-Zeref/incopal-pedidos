<div x-data="{ scrolled: false }" @scroll.window="scrolled = (window.innerHeight + window.scrollY) >= document.body.offsetHeight">
    {{-- BARRA DE FILTROS E PESQUISA --}}
    <div class="bg-white p-4 rounded-lg shadow-md mb-6 sticky top-0 z-10">
        {{-- LINHA 1: PESQUISA E OPÇÕES --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Digite para pesquisar..."
                class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" wire:model.live="matchAllWords" class="form-checkbox h-5 w-5 text-indigo-600">
                    <span class="ml-2 text-gray-700">Combinar todas as palavras</span>
                </label>
                <button wire:click="clearFilters" class="text-sm text-blue-600 hover:underline">Limpar Filtros</button>
            </div>
        </div>

        {{-- LINHA 2: CHECKBOXES DE COLUNAS --}}
        <div>
            <h4 class="font-semibold text-gray-700 mb-2">Buscar nas colunas:</h4>
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                {{-- Checkbox "Todas" --}}
                <label class="inline-flex items-center font-bold">
                    <input type="checkbox" wire:model.live="searchAllColumns" class="form-checkbox h-5 w-5 text-indigo-600">
                    <span class="ml-2">Todas</span>
                </label>
                {{-- Checkboxes individuais --}}
                @foreach ($availableColumns as $key => $label)
                <label class="inline-flex items-center" :class="{ 'opacity-50 cursor-not-allowed': $wire.searchAllColumns }">
                    <input type="checkbox" wire:model.live="selectedColumns" value="{{ $key }}"
                        :disabled="$wire.searchAllColumns"
                        class="form-checkbox h-5 w-5 text-gray-600">
                    <span class="ml-2">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- LISTA DE PRODUTOS EM TABELA --}}
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            {{-- Container com rolagem --}}
            <div class="max-h-[500px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 text-left sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Codigo</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Original</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Descrição</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Descrição2</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Secundario</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Localização</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Diversa</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Aplicação</th>
                            <th scope="col" class="px-4 py-2 bg-gray-100">Descrição3</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-700">
                        @forelse ($produtos as $index => $produto)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="px-4 py-2">{{ $produto->codigo }}</td>
                            <td class="px-4 py-2">{{ $produto->original ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->descricao ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->descricao2 ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->secundario ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->localizacao ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->diversa ?? '' }}</td>
                            <td class="px-4 py-2">{{ $produto->aplicacao ?? ''  }}</td>
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



        {{-- TRIGGER DO SCROLL INFINITO --}}
        <div x-show="scrolled" x-intersect.full="$wire.loadMore()" class="text-center py-4">
            <span class="text-gray-500">Carregando mais produtos...</span>
        </div>
    </div>