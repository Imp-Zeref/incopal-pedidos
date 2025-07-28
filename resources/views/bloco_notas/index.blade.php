<x-layouts.app>
    <x-slot name="title">Minhas Anotações</x-slot>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Minhas Anotações</h1>
        <a href="{{ route('bloco-notas.create') }}" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Nova Anotação</a>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <ul>
            @forelse($blocos as $bloco)
                <li class="flex justify-between items-center p-4 border hover:bg-gray-50">
                    <div>
                        <a href="{{ route('bloco-notas.show', $bloco) }}" class="font-semibold text-blue-600">{{ $bloco->titulo }}</a>
                        <p class="text-sm text-gray-500">Cliente: {{ $bloco->nome_cliente ?? 'N/A' }} | Produtos: {{ $bloco->produtos->count() }}</p>
                    </div>
                    <div class="flex space-x-2 items-center">
                        <a href="{{ route('bloco-notas.show', $bloco) }}" class="text-sm text-gray-600">Ver/Editar</a>
                        <form action="{{ route('bloco-notas.destroy', $bloco) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600">Excluir</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="p-4 text-center text-gray-500">Você ainda não tem nenhuma anotação.</li>
            @endforelse
        </ul>
    </div>
</x-layouts.app>