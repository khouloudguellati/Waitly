@extends('layouts.institution-admin')

@section('title', 'Gestion des Tickets')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Gestion des Tickets</h2>
            <p class="mt-1 text-sm text-gray-500">Sélectionnez un service pour gérer ses tickets</p>
        </div>

        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
                <a href="{{ route('institution-admin.tickets.by-service', $service) }}"
                    class="block bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $service->name }}
                                </h3>
                                <span class="text-xs {{ $service->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $service->is_active ? '● Actif' : '● Inactif' }}
                                </span>
                            </div>
                        </div>

                        
                        <div class="space-y-3">
                            
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="ml-2 text-sm font-medium text-yellow-800">En Attente</span>
                                </div>
                                <span class="text-2xl font-bold text-yellow-900">{{ $service->waiting_count }}</span>
                            </div>

                            
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>Temps estimé</span>
                                <span class="font-medium">{{ $service->estimated_time }} min</span>
                            </div>

                            @if ($service->daily_capacity)
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span>Capacité journalière</span>
                                    <span class="font-medium">{{ $service->daily_capacity }} tickets</span>
                                </div>
                            @endif
                        </div>

                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-between text-blue-600 hover:text-blue-700">
                                <span class="text-sm font-medium">Gérer les tickets</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-3">
                    <div class="text-center py-12 bg-white rounded-lg shadow">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun service actif</h3>
                        <p class="mt-1 text-sm text-gray-500">Créez d'abord des services pour gérer leurs tickets.</p>
                        <div class="mt-6">
                            <a href="{{ route('institution-admin.services.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Créer un Service
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        
        @if ($services->count() > 0)
            <div class="mt-8 bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Vue d'Ensemble de l'Institution
                    </h3>
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="px-4 py-5 bg-gray-50 shadow rounded-lg overflow-hidden">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Total Services Actifs
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                {{ $services->where('is_active', true)->count() }}
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-yellow-50 shadow rounded-lg overflow-hidden">
                            <dt class="text-sm font-medium text-yellow-700 truncate">
                                Total Tickets en Attente
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-yellow-900">
                                {{ $services->sum('waiting_count') }}
                            </dd>
                        </div>
                        <div class="px-4 py-5 bg-blue-50 shadow rounded-lg overflow-hidden">
                            <dt class="text-sm font-medium text-blue-700 truncate">
                                Temps Moyen de Service
                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-blue-900">
                                {{ round($services->avg('estimated_time')) }} min
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        @endif
    </div>
@endsection
