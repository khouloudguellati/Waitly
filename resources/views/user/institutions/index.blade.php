@extends('layouts.app')

@section('title', 'Choisir une Institution')

@section('content')
    <div class="max-w-7xl py-5 mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-400">Institutions Disponibles</h1>
            <p class="mt-2 text-sm text-gray-600">Choisissez l'institution pour réserver votre ticket</p>
        </div>

        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($institutions as $institution)
                <a href="{{ route('user.institutions.show', $institution) }}"
                    class="group bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        
                        <div
                            class="flex items-center justify-center h-16 w-16 rounded-full {{ $institution->type === 'mairie'
                                ? 'bg-blue-100'
                                : ($institution->type === 'hopital'
                                    ? 'bg-red-100'
                                    : ($institution->type === 'bureau_gouvernemental'
                                        ? 'bg-purple-100'
                                        : 'bg-gray-100')) }} mb-4">
                            @if ($institution->type === 'mairie')
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            @elseif($institution->type === 'hopital')
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            @else
                                <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            @endif
                        </div>

                        
                        <h3 class="text-lg font-semibold text-neutral-400 group-hover:text-blue-600 mb-2">
                            {{ $institution->name }}
                        </h3>

                        
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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

                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <span class="text-sm text-gray-600">
                                {{ $institution->services_count }}
                                {{ $institution->services_count > 1 ? 'services disponibles' : 'service disponible' }}
                            </span>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-neutral-400">Aucune institution disponible</h3>
                        <p class="mt-1 text-sm text-gray-500">Les institutions apparaîtront ici lorsqu'elles seront
                            ajoutées.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
