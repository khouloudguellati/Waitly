@extends('layouts.institution-admin')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Tableau de Bord</h1>
            <p class="mt-2 text-sm text-gray-600">{{ $institution->name }}</p>
        </div>

        
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Services</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_services'] }}</div>
                                    <div class="ml-2 text-sm font-medium text-green-600">
                                        {{ $stats['active_services'] }} actifs
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Tickets Aujourd'hui</dt>
                                <dd class="text-2xl font-semibold text-gray-900">{{ $stats['tickets_today'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-yellow-700 truncate">En Attente</dt>
                                <dd class="text-2xl font-semibold text-yellow-900">{{ $stats['waiting_tickets'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-green-700 truncate">Terminés Aujourd'hui</dt>
                                <dd class="text-2xl font-semibold text-green-900">{{ $stats['completed_today'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Files d'Attente par Service
                        </h3>
                        <a href="{{ route('institution-admin.tickets.index') }}"
                            class="text-sm font-medium text-blue-600 hover:text-blue-500">
                            Tout voir →
                        </a>
                    </div>
                    <div class="space-y-4">
                        @forelse($services_with_queue as $service)
                            <div
                                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-150">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $service->name }}</h4>
                                        <span
                                            class="ml-2 text-xs {{ $service->is_active ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $service->is_active ? '● Actif' : '● Inactif' }}
                                        </span>
                                    </div>
                                    <div class="mt-1 flex items-center text-xs text-gray-500">
                                        <svg class="flex-shrink-0 mr-1 h-3 w-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $service->estimated_time }} min par ticket
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-yellow-600">{{ $service->waiting_count }}</div>
                                        <div class="text-xs text-gray-500">en attente</div>
                                    </div>
                                    <a href="{{ route('institution-admin.tickets.by-service', $service) }}"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                        Gérer
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Aucun service actif</p>
                                <a href="{{ route('institution-admin.services.create') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                    Créer un Service
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Activité Récente
                    </h3>
                    <div class="flow-root">
                        <ul class="-my-5 divide-y divide-gray-200">
                            @forelse($recent_tickets as $ticket)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <span
                                                class="inline-flex items-center justify-center h-10 w-10 rounded-full {{ $ticket->status === 'waiting'
                                                    ? 'bg-yellow-100'
                                                    : ($ticket->status === 'called'
                                                        ? 'bg-blue-100'
                                                        : ($ticket->status === 'completed'
                                                            ? 'bg-green-100'
                                                            : 'bg-red-100')) }}">
                                                <span
                                                    class="text-sm font-medium {{ $ticket->status === 'waiting'
                                                        ? 'text-yellow-800'
                                                        : ($ticket->status === 'called'
                                                            ? 'text-blue-800'
                                                            : ($ticket->status === 'completed'
                                                                ? 'text-green-800'
                                                                : 'text-red-800')) }}">
                                                    #{{ $ticket->ticket_number }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $ticket->user->name }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $ticket->service->name }} • {{ $ticket->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $ticket->status === 'waiting'
                                                    ? 'bg-yellow-100 text-yellow-800'
                                                    : ($ticket->status === 'called'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : ($ticket->status === 'completed'
                                                            ? 'bg-green-100 text-green-800'
                                                            : 'bg-red-100 text-red-800')) }}">
                                                @if ($ticket->status === 'waiting')
                                                    Attente
                                                @elseif($ticket->status === 'called')
                                                    Appelé
                                                @elseif($ticket->status === 'completed')
                                                    Terminé
                                                @else
                                                    Annulé
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-center text-gray-500">Aucune activité récente</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('institution-admin.services.create') }}"
                class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg shadow hover:shadow-lg transition duration-150">
                <div>
                    <span class="rounded-lg inline-flex p-3 bg-blue-50 text-blue-700 ring-4 ring-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Créer un Service
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Ajoutez un nouveau service à votre institution
                    </p>
                </div>
            </a>

            <a href="{{ route('institution-admin.tickets.index') }}"
                class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg shadow hover:shadow-lg transition duration-150">
                <div>
                    <span class="rounded-lg inline-flex p-3 bg-indigo-50 text-indigo-700 ring-4 ring-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Gérer les Tickets
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Appelez et traitez les tickets en attente
                    </p>
                </div>
            </a>

            <a href="{{ route('institution-admin.services.index') }}"
                class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-500 rounded-lg shadow hover:shadow-lg transition duration-150">
                <div>
                    <span class="rounded-lg inline-flex p-3 bg-green-50 text-green-700 ring-4 ring-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </span>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        Mes Services
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Voir et modifier vos services
                    </p>
                </div>
            </a>
        </div>
    </div>
@endsection
