<div>
    {{-- BARRA DE FILTROS E PESQUISA --}}
    <div class="flex bg-white p-4 rounded-xl space-x-10 shadow-lg mb-2 flex-row">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pesquisar por código, nome, descrição, aplicação..."
            class="w-1/2 bg-gray-200 border-gray-400 rounded-lg shadow-md py-3 px-4 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <div class="flex items-center space-x-4 mt-2">
            <label class="flex items-center">
                <input type="checkbox" wire:model.live="useCommaAsAnd" class="form-checkbox h-5 w-5 text-indigo-600">
                <span class="ml-2 text-gray-700">Buscar termos separados por vírgula</span>
            </label>
        </div>
    </div>

    {{-- TABELA DE PRODUTOS --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-y-auto" style="max-height: 75vh;">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-2 w-2/12 text-left cursor-pointer font-bold uppercase" wire:click="sortBy('codigo')">
                            Código
                            @if($sortColumn === 'codigo')
                            @if($sortDirection === 'asc') ▲ @else ▼ @endif
                            @endif
                        </th>
                        <th class="px-4 py-2 w-2/12 text-left cursor-pointer font-bold uppercase" wire:click="sortBy('original')">
                            Original
                            @if($sortColumn === 'original')
                            @if($sortDirection === 'asc') ▲ @else ▼ @endif
                            @endif
                        </th>
                        <th class="px-4 py-2 w-2/12 text-left cursor-pointer font-bold uppercase" wire:click="sortBy('descricao')">
                            Descricao
                            @if($sortColumn === 'descricao')
                            @if($sortDirection === 'asc') ▲ @else ▼ @endif
                            @endif
                        </th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Descrição2</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Secundário</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Localização</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Diversa</th>
                        <th class="px-4 py-3 w-1/12 text-left font-bold uppercase tracking-wider">Preço</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700" wire:loading.class.delay="opacity-50">
                    @forelse ($produtos as $produto)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-4 py-2 ">{{ $produto->codigo }}</td>
                        <td class="px-4 py-2">{{ $produto->original ?? '' }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $produto->descricao ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->descricao2 ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->secundario ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->localizacao ?? '' }}</td>
                        <td class="px-4 py-2">{{ $produto->diversa ?? '' }}</td>
                        <td class="px-4 py-2">
                            R$ {{ number_format($produto->preco ?? 0, 2, ',', '.') }}
                        </td>
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

            {{-- GATILHO DE CARREGAMENTO AUTOMÁTICO --}}
            @if(count($produtos) < $totalProducts)
                <div x-data="{
                    init() {
                        let observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    @this.call('loadMore')
                                }
                            })
                        });
                        observer.observe(this.$el);
                    }
                }" class="p-6 text-center">
                <div wire:loading wire:target="loadMore">
                    <p class="text-gray-500 animate-pulse">Carregando...</p>
                </div>
        </div>
        @else
        @if($totalProducts > 0)
        <div class="p-6 text-center text-gray-500">
            Fim dos resultados.
        </div>
        @endif
        @endif
    </div>
</div>
</div>