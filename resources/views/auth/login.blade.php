<x-layouts.app>
    <x-slot name="title">
        Login
    </x-slot>

    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg p-8">
                <h1 class="text-2xl font-bold text-center mb-6">Acessar Sistema</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">
                            Nome de Usuário
                        </label>
                        <input id="nome" type="text" name="nome" value="{{ old('nome') }}" required autofocus
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nome') border-red-500 @enderror">
                        
                        @error('nome')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                            Senha
                        </label>
                        <input id="password" type="password" name="password" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox">
                            <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>