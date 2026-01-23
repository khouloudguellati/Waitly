@extends('layouts.institution-admin')

@section('title', 'Gestion des Services')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Mes Services</h2>
                <p class="mt-1 text-sm text-gray-500">Gérez les services de votre institution</p>
            </div>
            <a href="{{ route('institution-admin.services.create') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouveau Service
            </a>
        </div>

        
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($services as $service)
                    <li>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <h3 class="text-lg font-medium text-gray-900 truncate">
                                            {{ $service->name }}
                                        </h3>
                                        <span
                                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $service->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </div>
                                    @if ($service->description)
                                        <p class="mt-1 text-sm text-gray-500">{{ $service->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center text-sm text-gray-500 space-x-4">
                                        <span class="flex items-center">
                                            <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Temps estimé: {{ $service->estimated_time }} min
                                        </span>
                                        @if ($service->daily_capacity)
                                            <span>
                                                Capacité: {{ $service->daily_capacity }} tickets/jour
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-600">
                                        <span class="mr-4">
                                            <strong class="text-blue-600">{{ $service->today_tickets }}</strong> tickets
                                            aujourd'hui
                                        </span>
                                        <span>
                                            <strong class="text-yellow-600">{{ $service->waiting_tickets }}</strong> en
                                            attente
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex space-x-2">
                                    <a href="{{ route('institution-admin.tickets.by-service', $service) }}"
                                        class="inline-flex items-center px-3 py-2 border border-blue-300 shadow-sm text-sm leading-4 font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        Gérer Tickets
                                    </a>
                                    <a href="{{ route('institution-admin.services.edit', $service) }}"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Modifier
                                    </a>
                                    <form action="{{ route('institution-admin.services.destroy', $service) }}"
                                        method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce service ?');">
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
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun service</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par créer votre premier service.</p>
                        <div class="mt-6">
                            <a href="{{ route('institution-admin.services.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nouveau Service
                            </a>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>

        
        @if ($services->hasPages())
            <div class="mt-6">
                {{ $services->links() }}
            </div>
        @endif
    </div>
@endsection
