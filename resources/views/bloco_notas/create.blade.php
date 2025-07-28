<x-layouts.app>
    <x-slot name="title">Nova Anotação</x-slot>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Criar Nova Anotação</h1>
    <form action="{{ route('bloco-notas.store') }}" method="POST" class="bg-white p-6 rounded-xl shadow-lg">
        @csrf
        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-600 mb-1">Título da Anotação</label>
            <input type="text" name="titulo" id="titulo" class="w-full border-gray-300 rounded-lg shadow-sm" required>
        </div>
        <div class="mt-6 text-right">
            <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Criar e Continuar</button>
        </div>
    </form>
</x-layouts.app>