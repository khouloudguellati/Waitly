@extends('layouts.super-admin')

@section('title', 'Gestion des Institutions')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Institutions</h2>
                <p class="mt-1 text-sm text-gray-500">Gérez toutes les institutions de la plateforme</p>
            </div>
            <a href="{{ route('super-admin.institutions.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouvelle Institution
            </a>
        </div>

        
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($institutions as $institution)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <h3 class="text-lg font-medium text-gray-900 truncate">
                                            {{ $institution->name }}
                                        </h3>
                                        <span
                                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $institution->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $institution->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $institution->city }}
                                        <span class="mx-2">•</span>
                                        <span class="capitalize">{{ str_replace('_', ' ', $institution->type) }}</span>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <span class="mr-4">
                                            <strong>{{ $institution->services_count }}</strong> services
                                        </span>
                                        <span class="mr-4">
                                            <strong>{{ $institution->admins_count }}</strong> administrateurs
                                        </span>
                                        <span>
                                            <strong>{{ $institution->tickets_count }}</strong> tickets
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex space-x-2">
                                    <a href="{{ route('super-admin.institutions.edit', $institution) }}"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Modifier
                                    </a>
                                    <form action="{{ route('super-admin.institutions.destroy', $institution) }}"
                                        method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette institution ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune institution</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par créer une nouvelle institution.</p>
                        <div class="mt-6">
                            <a href="{{ route('super-admin.institutions.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nouvelle Institution
                            </a>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>

        
        @if ($institutions->hasPages())
            <div class="mt-6">
                {{ $institutions->links() }}
            </div>
        @endif
    </div>
@endsection
