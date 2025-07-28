<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Calculadora de Frete</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg">
            <form wire:submit="calcularFrete">
                <div class="space-y-4">
                    <div>
                        <label for="cepOrigem" class="block text-sm font-medium text-gray-600 mb-1">CEP de Origem</label>
                        <input type="text" id="cepOrigem" wire:model="cepOrigem" placeholder="Apenas números" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        @error('cepOrigem') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="cepDestino" class="block text-sm font-medium text-gray-600 mb-1">CEP de Destino</label>
                        <input type="text" id="cepDestino" wire:model="cepDestino" placeholder="Apenas números" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        @error('cepDestino') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="peso" class="block text-sm font-medium text-gray-600 mb-1">Peso (kg)</label>
                        <input type="number" step="0.1" id="peso" wire:model="peso" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        @error('peso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label for="altura" class="block text-sm font-medium text-gray-600 mb-1">Altura (cm)</label>
                            <input type="number" id="altura" wire:model="altura" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label for="largura" class="block text-sm font-medium text-gray-600 mb-1">Largura (cm)</label>
                            <input type="number" id="largura" wire:model="largura" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label for="comprimento" class="block text-sm font-medium text-gray-600 mb-1">Comp. (cm)</label>
                            <input type="number" id="comprimento" wire:model="comprimento" class="p-2 border w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md">
                        <span wire:loading.remove>Calcular Frete</span>
                        <span wire:loading>Calculando...</span>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="lg:col-span-2">
            <div wire:loading wire:target="calcularFrete" class="text-center">
                <p class="text-gray-500">Buscando cotações...</p>
            </div>

            @if($erro)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                    <p class="font-bold">Erro</p>
                    <p>{{ $erro }}</p>
                </div>
            @endif

            @if(!empty($cotacoes))
                <div class="space-y-4">
                    @forelse($cotacoes as $cotacao)
                        @if(!isset($cotacao['error']))
                            <div class="bg-white p-4 rounded-xl shadow-lg flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $cotacao['company']['picture'] }}" alt="{{ $cotacao['company']['name'] }}" class="h-10 w-10">
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $cotacao['name'] }}</p>
                                        <p class="text-sm text-gray-500">Prazo de entrega: {{ $cotacao['delivery_time'] }} dias</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-blue-700">R$ {{ number_format($cotacao['price'], 2, ',', '.') }}</p>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p class="text-gray-500">Nenhuma opção de frete encontrada para os dados informados.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>