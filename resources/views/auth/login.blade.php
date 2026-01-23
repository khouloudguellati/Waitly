@extends('layouts.app')

@section('title', 'Connexion - Waitly')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] py-5 flex items-center justify-center px-6">

        <div
            class="w-full max-w-md bg-white/5 backdrop-blur-xl
               border border-white/10 rounded-3xl shadow-2xl p-10">

            <div class="text-center">
                <div
                    class="mx-auto h-14 w-14 flex items-center justify-center rounded-2xl
                       bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg">
                    <i data-lucide="log-in"></i>
                </div>

                <h2 class="mt-6 text-3xl font-extrabold">Connexion</h2>

                <p class="mt-2 text-sm text-slate-300">
                    Vous n’avez pas de compte ?
                    <a href="{{ route('register') }}" class="text-blue-400 hover:underline">
                        Inscription citoyen
                    </a>
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Adresse e-mail
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900/60 border
                               @error('email') border-red-500 @else border-white/10 @enderror
                               focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </span>
                        <input type="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900/60 border
                               @error('password') border-red-500 @else border-white/10 @enderror
                               focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-slate-300">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 rounded border-gray-300">
                        <span class="ml-2">Se souvenir de moi</span>
                    </label>
                </div>

                <button type="submit"
                    class="group w-full flex justify-center items-center gap-2
                       py-3 rounded-xl text-white font-semibold
                       bg-gradient-to-r from-blue-600 to-indigo-600
                       hover:scale-[1.02] hover:shadow-xl transition">
                    Se connecter
                    <i data-lucide="arrow-right" class="group-hover:translate-x-1 transition"></i>
                </button>
            </form>

            <p class="mt-8 text-center text-xs text-slate-500">
                © {{ date('Y') }} Waitly — Tous droits réservés
            </p>
        </div>
    </div>
@endsection
