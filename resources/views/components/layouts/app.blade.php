<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Incopal Pedidos' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <a href="/" class="text-xl font-bold">Incopal Pedidos</a>
            </div>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('pedidos.index') }}" class="hover:text-blue-600">Meus Pedidos</a>
                    
                    {{-- <form method="POST" action="{{ route('logout') }}" class="inline"> --}}
                        @csrf
                        <button type="submit" class="hover:text-blue-600">Sair</button>
                    </form>
                @else
                    {{-- <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-blue-600">Registrar</a> --}}
                @endauth
            </div>
        </nav>
    </header>

    <main class="container mx-auto px-6 py-8">
        {{ $slot }}
    </main>

    <footer class="bg-white mt-auto py-4">
        <div class="container mx-auto text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Incopal Pedidos - Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>