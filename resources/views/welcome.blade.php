<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waitly – Gestion des Files d'Attente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @layer utilities {
            .animate-fade-in {
                animation: fadeIn 0.8s ease-out forwards;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 text-gray-800">


    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">


                <div class="flex items-center space-x-2">
                    <div
                        class="h-9 w-9 flex items-center justify-center rounded-xl bg-gradient-to-r from-amber-400 to-amber-600 text-white">
                        <i data-lucide="clock"></i>
                    </div>
                    <span class="text-xl font-extrabold text-gray-900">Waitly</span>
                </div>


                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('user.dashboard') }}"
                            class="relative px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition
                                   after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0
                                   after:bg-indigo-800 hover:after:w-full after:transition-all">
                            Tableau de Bord
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="px-4 py-2 rounded-lg text-sm font-medium text-white
                                       bg-gradient-to-r from-red-500 to-red-600 hover:scale-105 transition">
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">
                            Connexion
                        </a>

                        <a href="{{ route('register') }}"
                            class="px-5 py-2 rounded-xl text-sm font-semibold text-white
                                   bg-gradient-to-r from-blue-600 to-indigo-600
                                   hover:scale-105 hover:shadow-lg transition">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    <section class="relative overflow-hidden bg-slate-950 text-white">
        
        <div class="absolute -top-32 -left-32 w-[500px] h-[500px] bg-indigo-600/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-32 w-[500px] h-[500px] bg-blue-600/30 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-6 py-32">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                
                <div>
                    <span
                        class="inline-flex items-center px-4 py-1.5 rounded-full
                           bg-white/10 text-sm font-medium text-indigo-300">
                        🚀 Plateforme nationale
                    </span>

                    <h1 class="mt-6 text-4xl sm:text-5xl xl:text-6xl font-extrabold leading-tight">
                        Gérez vos files d’attente
                        <span
                            class="block bg-gradient-to-r from-blue-400 to-indigo-400
                               bg-clip-text text-transparent">
                            sans perdre une minute
                        </span>
                    </h1>

                    <p class="mt-6 max-w-xl text-lg text-slate-300">
                        Une solution intelligente pour organiser les rendez-vous,
                        réduire l’attente physique et améliorer l’expérience citoyen.
                    </p>

                    
                    <div class="mt-10 flex flex-wrap gap-4">
                        @guest
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 px-8 py-4 rounded-xl
                               bg-gradient-to-r from-blue-600 to-indigo-600
                               font-semibold text-lg
                               hover:scale-105 hover:shadow-2xl transition">
                                Commencer
                                <i data-lucide="arrow-right"></i>
                            </a>

                            <a href="{{ route('login') }}"
                                class="inline-flex items-center px-8 py-4 rounded-xl
                               border border-white/20
                               text-lg font-semibold text-white
                               hover:bg-white/10 transition">
                                Se connecter
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('user.dashboard') }}"
                                class="inline-flex items-center gap-2 px-8 py-4 rounded-xl
                               bg-gradient-to-r from-blue-600 to-indigo-600
                               font-semibold text-lg
                               hover:scale-105 hover:shadow-2xl transition">
                                Tableau de Bord
                                <i data-lucide="arrow-right"></i>
                            </a>
                        @endauth
                    </div>
                </div>

                
                <div class="relative">
                    <div
                        class="rounded-3xl bg-white/5 backdrop-blur-xl
                           border border-white/10 shadow-2xl p-6">

                        <div class="space-y-4">
                            <div class="h-4 w-1/3 bg-white/20 rounded"></div>
                            <div class="h-4 w-1/2 bg-white/20 rounded"></div>

                            <div class="mt-6 grid grid-cols-3 gap-4">
                                <div class="h-20 rounded-xl bg-indigo-500/30"></div>
                                <div class="h-20 rounded-xl bg-blue-500/30"></div>
                                <div class="h-20 rounded-xl bg-sky-500/30"></div>
                            </div>

                            <div class="mt-6 h-24 rounded-xl bg-white/10"></div>
                        </div>
                    </div>

                    
                    <div
                        class="absolute -bottom-6 -left-6
                           bg-indigo-600 text-white
                           px-5 py-3 rounded-xl shadow-xl">
                        ⏱ Temps d’attente réduit
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="relative py-32 bg-slate-950 text-white overflow-hidden">
        
        <div class="absolute inset-0 bg-gradient-to-b from-indigo-950/40 to-slate-950"></div>

        <div class="relative max-w-7xl mx-auto px-6">
            
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="inline-block mb-4 px-4 py-1 rounded-full bg-white/10 text-indigo-300 text-sm">
                    Fonctionnalités clés
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    Une plateforme pensée pour
                    <span class="bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                        l’efficacité
                    </span>
                </h2>
                <p class="mt-6 text-lg text-slate-300">
                    Simplifiez la gestion des files d’attente grâce à une solution moderne,
                    sécurisée et performante.
                </p>
            </div>

            
            <div class="grid md:grid-cols-3 gap-10">
                
                <div
                    class="group relative p-10 rounded-3xl bg-white/5 backdrop-blur-xl
                       border border-white/10 hover:border-indigo-500/50
                       hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 flex items-center justify-center rounded-2xl
                           bg-indigo-500/20 mb-6 group-hover:bg-indigo-600 transition">
                        <i data-lucide="clock" class="w-8 h-8 text-indigo-400 group-hover:text-white"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">Gain de temps</h3>
                    <p class="text-slate-300">
                        Réservez vos tickets à distance et éliminez l’attente physique inutile.
                    </p>
                </div>

                <div
                    class="group relative p-10 rounded-3xl bg-white/5 backdrop-blur-xl
                       border border-white/10 hover:border-emerald-500/50
                       hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 flex items-center justify-center rounded-2xl
                           bg-emerald-500/20 mb-6 group-hover:bg-emerald-600 transition">
                        <i data-lucide="shield-check" class="w-8 h-8 text-emerald-400 group-hover:text-white"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">Sécurité maximale</h3>
                    <p class="text-slate-300">
                        Données protégées par des standards élevés et une architecture fiable.
                    </p>
                </div>

                <div
                    class="group relative p-10 rounded-3xl bg-white/5 backdrop-blur-xl
                       border border-white/10 hover:border-purple-500/50
                       hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 flex items-center justify-center rounded-2xl
                           bg-purple-500/20 mb-6 group-hover:bg-purple-600 transition">
                        <i data-lucide="zap" class="w-8 h-8 text-purple-400 group-hover:text-white"></i>
                    </div>

                    <h3 class="text-xl font-semibold mb-3">Rapide & intuitif</h3>
                    <p class="text-slate-300">
                        Une interface fluide pensée pour citoyens et institutions.
                    </p>
                </div>
            </div>
        </div>
    </section>



    <section class="py-32 bg-slate-900 text-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <span class="inline-block mb-4 px-4 py-1 rounded-full bg-white/10 text-indigo-300 text-sm">
                    Processus
                </span>
                <h2 class="text-4xl md:text-5xl font-extrabold">
                    Comment ça marche ?
                </h2>
                <p class="mt-6 text-slate-300 text-lg">
                    Un parcours simple et rapide en quatre étapes.
                </p>
            </div>

            <div class="relative grid md:grid-cols-4 gap-12">
                @foreach ([['user-plus', 'Inscription'], ['building', 'Choix du service'], ['ticket', 'Réservation'], ['check', 'Confirmation']] as $i => $step)
                    <div class="relative flex flex-col items-center text-center group">
                        <div
                            class="w-20 h-20 flex items-center justify-center rounded-2xl
                               bg-gradient-to-br from-blue-500 to-indigo-600
                               text-2xl font-bold mb-6
                               group-hover:scale-110 transition">
                            {{ $i + 1 }}
                        </div>

                        <i data-lucide="{{ $step[0] }}"
                            class="w-10 h-10 text-indigo-400 mb-3 group-hover:text-indigo-300 transition"></i>

                        <h4 class="text-lg font-semibold">{{ $step[1] }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




    <footer class="bg-slate-950 text-slate-400 py-16">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-2xl font-extrabold text-white tracking-wide">
                Waitly
            </h3>

            <p class="mt-3 text-sm">
                Plateforme Nationale de Gestion des Files d’Attente
            </p>

            <div class="flex justify-center gap-6 mt-8">
                <i data-lucide="github" class="w-5 h-5 hover:text-white transition"></i>
                <i data-lucide="twitter" class="w-5 h-5 hover:text-white transition"></i>
                <i data-lucide="mail" class="w-5 h-5 hover:text-white transition"></i>
            </div>

            <div class="mt-10 border-t border-white/10 pt-6 text-xs">
                © {{ date('Y') }} Waitly — Tous droits réservés.
            </div>
        </div>
    </footer>


    <script>
        lucide.createIcons();
    </script>

</body>

</html>
