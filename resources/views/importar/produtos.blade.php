<x-layouts.app>
    <x-slot name="title">
        Importar Produtos
    </x-slot>

    <h1 class="text-2xl font-bold mb-6">Importar e Atualizar Produtos via CSV</h1>

    <div class="bg-white p-8 rounded-lg shadow-md max-w-xl">
        
        {{-- Mensagem de Sucesso --}}
        @if (session('sucesso'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('sucesso') }}</span>
            </div>
        @endif

        <p class="text-gray-600 mb-4">
            Selecione um arquivo CSV (.csv ou .txt) para cadastrar novos produtos ou atualizar os existentes. A verificação é feita pelo campo "codigo".
        </p>

        <form action="{{ route('import.produtos.run') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="arquivo_csv" class="block text-sm font-medium text-gray-700">Arquivo CSV</label>
                <input type="file" name="arquivo_csv" id="arquivo_csv" required
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                
                @error('arquivo_csv')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Enviar e Processar
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>