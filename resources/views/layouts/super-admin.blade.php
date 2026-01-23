<!DOCTYPE html>
<html lang="fr" x-data="{ sidebarOpen: false }" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Super Admin - E-Queue')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @layer utilities {
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex">

    
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-blue-900 text-blue-100 transform md:translate-x-0 md:static transition-transform duration-200">

        <div class="flex flex-col h-full">

            
            <div class="flex items-center justify-center h-16 bg-blue-950">
                <span class="text-xl font-bold tracking-wide text-white">Super Admin</span>
            </div>

            
            <nav class="flex-1 px-3 py-4 space-y-1">

                <a href="{{ route('super-admin.dashboard') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition
                   {{ request()->routeIs('super-admin.dashboard')
                       ? 'bg-blue-800 text-white'
                       : 'text-blue-200 hover:bg-blue-700 hover:text-white' }}">
                    <i data-lucide="home" class="w-5 h-5 mr-3 text-blue-300"></i>
                    Tableau de Bord
                </a>

                <a href="{{ route('super-admin.institutions.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition
                   {{ request()->routeIs('super-admin.institutions.*')
                       ? 'bg-blue-800 text-white'
                       : 'text-blue-200 hover:bg-blue-700 hover:text-white' }}">
                    <i data-lucide="building" class="w-5 h-5 mr-3 text-blue-300"></i>
                    Institutions
                </a>

                <a href="{{ route('super-admin.admins.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition
                   {{ request()->routeIs('super-admin.admins.*')
                       ? 'bg-blue-800 text-white'
                       : 'text-blue-200 hover:bg-blue-700 hover:text-white' }}">
                    <i data-lucide="user" class="w-5 h-5 mr-3 text-blue-300"></i>
                    Administrateurs
                </a>

            </nav>

            
            <div class="p-4 bg-blue-950 mt-auto">
                <div class="flex items-center">
                    <div class="h-9 w-9 rounded-full bg-blue-800 flex items-center justify-center">
                        <span class="text-xs font-semibold text-white">SA</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">
                            {{ auth()->user()->name }}
                        </p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="text-xs text-blue-300 hover:text-white transition">
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </aside>

    
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 md:hidden"></div>

    
    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="bg-white shadow">
            <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center">
                <button @click="sidebarOpen = true" class="md:hidden mr-4 text-gray-600">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
                <h2 class="text-2xl font-bold text-gray-900">@yield('title')</h2>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto py-6 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
