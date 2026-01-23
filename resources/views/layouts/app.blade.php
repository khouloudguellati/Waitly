<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Waitly')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen flex flex-col bg-slate-950 text-white">

    
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center"> <a href="{{ route('home') }}" class="flex items-center">
                        <div class="flex items-center space-x-2">
                            <div
                                class="h-9 w-9 flex items-center justify-center rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 text-white">
                                <i data-lucide="clock"></i> </div> <span
                                class="text-xl font-extrabold text-gray-900">Waitly</span>
                        </div>
                    </a> </div>
                <div class="flex items-center space-x-4"> @auth <span
                            class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Se déconnecter </button> </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"> Connexion
                        </a> <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                        Inscription </a> @endauth
                </div>
            </div>
        </div>
    </nav>

    
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="max-w-5xl mx-auto px-6 mt-6">
            <div
                class="rounded-xl bg-emerald-500/10 border border-emerald-500/30
                       p-4 flex items-center gap-3">
                <i data-lucide="check-circle" class="text-emerald-400"></i>
                <p class="text-emerald-300 text-sm">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-emerald-400 hover:text-white">✕</button>
            </div>
        </div>
    @endif

    
    <main class="flex-1">
        @yield('content')
    </main>

    
    <footer class="border-t border-white/10 py-10 text-center text-slate-400 text-sm">
        <h3 class="text-white font-bold tracking-wide">Waitly</h3>
        <p class="mt-2">Plateforme Nationale de Gestion des Files d’Attente</p>
        <p class="mt-4 text-xs">© {{ date('Y') }} Tous droits réservés</p>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
