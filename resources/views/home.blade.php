<x-layouts.app>
    <div class="text-center">

        @guest
            {{-- Conteúdo para Visitantes (Não Logados) --}}
            <div class="bg-white p-12 rounded-lg shadow-lg">
                <h1 class="text-4xl font-bold text-gray-800">
                    Bem-vindo ao Incopal Pedidos
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    O sistema interno para gerenciamento de pedidos dos vendedores.
                </p>
                <div class="mt-8 space-x-4">
                    <a href="{{ route('login') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                        Fazer Login
                    </a>
                </div>
            </div>
        @endguest

        @auth
            {{-- Conteúdo para Usuários Logados --}}
            <div class="bg-white p-12 rounded-lg shadow-lg">
                <h1 class="text-4xl font-bold text-gray-800">
                    Bem-vindo de volta, {{ Auth::user()->nome }}!
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Gerencie seus pedidos de forma rápida e eficiente.
                </p>
                <div class="mt-8">
                    <a href="{{ route('pedidos.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg">
                        Ver Meus Pedidos
                    </a>
                </div>
            </div>
        @endauth

    </div>
</x-layouts.app>