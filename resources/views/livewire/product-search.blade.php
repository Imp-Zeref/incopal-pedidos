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

        {{-- LISTA DE PRODUTOS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($produtos as $produto)
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col">
                <p class="text-gray-600 text-sm mb-2 flex-grow">{{ $produto->descricao ?? 'Sem descrição.' }}</p>
                <div class="text-xs text-gray-500 mt-2">
                    <p><strong>Original:</strong> {{ $produto->original ?? 'N/A' }}</p>
                    <p><strong>Localização:</strong> {{ $produto->localizacao ?? 'N/A' }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Nenhum produto encontrado com os filtros atuais.</p>
            </div>
            @endforelse
        </div>

        {{-- TRIGGER DO SCROLL INFINITO --}}
        <div x-show="scrolled" x-intersect.full="$wire.loadMore()" class="text-center py-4">
            <span class="text-gray-500">Carregando mais produtos...</span>
        </div>
    </div>