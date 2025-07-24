<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Incopal Pedidos' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

{{-- A mágica acontece aqui no body --}}
<body class="bg-gray-100 text-gray-900 h-screen flex flex-col">

    <header class="bg-white shadow-md z-20">
        {{-- O conteúdo do seu header não muda --}}
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <a href="{{ route('home') }}" class="text-xl font-bold">Incopal Pedidos</a>
            </div>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('pedidos.index') }}" class="hover:text-blue-600">Meus Pedidos</a>
                    @if (auth()->user()->tipoUsuario->nome === 'Administrador')
                        <a href="{{ route('import.produtos.form') }}" class="hover:text-blue-600">Atualizar Produtos</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-600">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- A área principal agora controla o próprio scroll --}}
    <main class="container mx-auto px-6 py-8 flex-grow overflow-y-auto">
        {{ $slot }}
    </main>

    <footer class="bg-white shadow-md z-20">
        {{-- O conteúdo do seu footer não muda --}}
        <div class="container mx-auto text-center text-sm text-gray-500 py-4">
            <p>&copy; {{ date('Y') }} Incopal Pedidos - Todos os direitos reservados.</p>
        </div>
    </footer>
    
    @livewireScripts
</body>

</html>