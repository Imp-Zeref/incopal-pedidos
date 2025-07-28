<x-layouts.app>
    <x-slot name="title">
        Importar Produtos
    </x-slot>

    <h1 class="text-2xl font-bold mb-6">Importar e Atualizar Produtos via CSV</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
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

        <div class="bg-white p-6 rounded-lg shadow-md flex flex-col space-y-4">
            <div class="mb-4 p-4 bg-white shadow-md rounded-lg">
                @if($jobsPendentes > 0)
                <p class="text-yellow-600 font-semibold">Processo em andamento...</p>
                @else
                <p class="text-gray-600">Nenhum processo ativo.</p>
                @endif
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Falhas Recentes</h2>

                @if ($falhas->isEmpty())
                <p class="text-gray-500">Nenhuma falha registrada.</p>
                @else
                <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-md p-3 bg-gray-50">
                    @foreach ($falhas as $falha)
                    <div class="mb-3 border-b pb-2">
                        <p class="text-sm text-red-700 font-semibold">UUID: {{ $falha->uuid }}</p>
                        <p class="text-xs text-gray-600">Queue: {{ $falha->queue }}</p>
                        <p class="text-xs text-gray-600">Data: {{ \Carbon\Carbon::parse($falha->failed_at)->format('d/m/Y H:i') }}</p>
                        <p class="text-xs text-gray-800 mt-1"><strong>Erro:</strong> {{ Str::limit($falha->exception, 200) }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>