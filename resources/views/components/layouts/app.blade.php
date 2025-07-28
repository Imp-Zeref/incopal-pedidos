<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SistBalc' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 h-screen flex flex-col font-sans">
    <header class="bg-white shadow-md z-20 flex-shrink-0 border-b-4 border-blue-600">
        <nav class="px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div>
                <a href="{{ route('home') }}"
                    class="text-2xl font-bold text-blue-700 hover:text-blue-800 transition-colors">
                    SistBalc
                </a>
                @if (Auth::check())
                    <span>Olá, {{ Auth::user()->nome }}!</span>
                @endif
            </div>
            <div class="space-x-4 flex items-center">
                @auth
                    <a href="{{ route('bloco-notas.index') }}" class="text-gray-600 hover:text-blue-600 font-medium">Bloco
                        de Notas</a>
                    <a href="{{ route('ferramentas.frete') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium">Calcular Frete</a>
                    @if (auth()->user()->tipoUsuario->nome === 'Administrador')
                        <a href="{{ route('import.produtos.form') }}"
                            class="text-gray-600 hover:text-blue-600 font-medium">Importar Produtos</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded-md text-sm transition-colors">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Login</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="px-2 py-2 overflow-y-auto">
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>
