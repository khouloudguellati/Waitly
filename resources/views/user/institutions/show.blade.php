@extends('layouts.app')

@section('title', $institution->name)

@section('content')
    <div class="max-w-7xl py-5 mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-6 py-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-6 flex-1">
                        <h1 class="text-3xl font-bold text-neutral-400">{{ $institution->name }}</h1>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $institution->address }}, {{ $institution->city }}
                        </div>
                        @if ($institution->phone)
                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $institution->phone }}
                            </div>
                        @endif
                        @if ($institution->description)
                            <p class="mt-3 text-sm text-gray-600">{{ $institution->description }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="mb-4">
            <h2 class="text-2xl font-bold text-neutral-400">Services Disponibles</h2>
            <p class="mt-1 text-sm text-gray-600">Sélectionnez un service pour réserver votre ticket</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-neutral-400 mb-2">{{ $service->name }}</h3>

                        @if ($service->description)
                            <p class="text-sm text-gray-600 mb-4">{{ $service->description }}</p>
                        @endif

                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-2 h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Temps estimé: <strong class="ml-1 text-neutral-400">{{ $service->estimated_time }} min</strong>
                            </div>
                            <div class="flex items-center text-sm">
                                <svg class="flex-shrink-0 mr-2 h-4 w-4 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span class="text-yellow-700">{{ $service->waiting_count }} personnes en attente</span>
                            </div>
                        </div>

                        <a href="{{ route('user.tickets.create', $service) }}"
                            class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-800 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Réserver un Ticket
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-neutral-400">Aucun service disponible</h3>
                    <p class="mt-1 text-sm text-gray-500">Cette institution n'a pas encore de services actifs.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            <a href="{{ route('user.institutions.index') }}"
                class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Retour aux institutions
            </a>
        </div>
    </div>
@endsection
