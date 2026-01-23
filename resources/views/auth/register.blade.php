@extends('layouts.app')

@section('title', 'Inscription - Waitly')

@section('content')
    <div class="min-h-[calc(100vh-4rem)] py-5 flex items-center justify-center px-6">

        <div
            class="w-full max-w-md bg-white/5 backdrop-blur-xl
               border border-white/10 rounded-3xl shadow-2xl p-10">

            <div class="text-center">
                <div
                    class="mx-auto h-14 w-14 flex items-center justify-center rounded-2xl
                       bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg">
                    <i data-lucide="user-plus"></i>
                </div>

                <h2 class="mt-6 text-3xl font-extrabold">Créer un compte citoyen</h2>

                <p class="mt-2 text-sm text-slate-300">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-blue-400 hover:underline">
                        Connexion
                    </a>
                </p>
            </div>

            <form class="mt-8 space-y-5" action="{{ route('register') }}" method="POST">
                @csrf

                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Nom complet *
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900/60 border
                               @error('name') border-red-500 @else border-white/10 @enderror
                               focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Adresse e-mail *
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
                        Numéro de téléphone
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <i data-lucide="phone" class="w-5 h-5"></i>
                        </span>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900/60 border
                               @error('phone') border-red-500 @else border-white/10 @enderror
                               focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Mot de passe *
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

                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">
                        Confirmer le mot de passe *
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                            <i data-lucide="lock-keyhole" class="w-5 h-5"></i>
                        </span>
                        <input type="password" name="password_confirmation" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-900/60 border border-white/10
                               focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <button type="submit"
                    class="group w-full flex justify-center items-center gap-2
                       py-3 rounded-xl text-white font-semibold
                       bg-gradient-to-r from-blue-600 to-indigo-600
                       hover:scale-[1.02] hover:shadow-xl transition">
                    Créer mon compte
                    <i data-lucide="arrow-right" class="group-hover:translate-x-1 transition"></i>
                </button>

                <p class="text-xs text-center text-slate-400">
                    En vous inscrivant, vous acceptez nos conditions d’utilisation.
                </p>
            </form>

            <p class="mt-6 text-center text-xs text-slate-500">
                © {{ date('Y') }} Waitly — Tous droits réservés
            </p>
        </div>
    </div>
@endsection
