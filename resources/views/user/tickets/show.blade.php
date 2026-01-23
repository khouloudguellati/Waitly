@extends('layouts.app')

@section('title', 'Mon Ticket')

@section('content')
    <div class="max-w-3xl py-5 mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">

            <div
                class="px-6 py-8 {{ $ticket->status === 'waiting'
                    ? 'bg-gradient-to-r from-yellow-400 to-yellow-500'
                    : ($ticket->status === 'called'
                        ? 'bg-gradient-to-r from-blue-500 to-blue-600'
                        : ($ticket->status === 'completed'
                            ? 'bg-gradient-to-r from-green-500 to-green-600'
                            : 'bg-gradient-to-r from-red-500 to-red-600')) }}">
                <div class="text-center">
                    <h1 class="text-white text-5xl font-bold mb-2">
                        {{ $ticket->getFormattedTicketNumber() }}
                    </h1>
                    <p class="text-white text-xl font-semibold">
                        @if ($ticket->status === 'waiting')
                            Votre ticket est en attente
                        @elseif($ticket->status === 'called')
                            🔔 Votre ticket a été appelé !
                        @elseif($ticket->status === 'completed')
                            ✅ Service terminé
                        @else
                            ❌ Ticket annulé
                        @endif
                    </p>
                </div>
            </div>


            <div class="px-6 py-6">
                <div class="space-y-6">

                    <div>
                        <h3 class="text-lg font-medium text-neutral-400 mb-4">Informations du Service</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Institution</p>
                                    <p class="text-base font-semibold text-neutral-400">{{ $ticket->institution->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->institution->address }},
                                        {{ $ticket->institution->city }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Service</p>
                                    <p class="text-base font-semibold text-neutral-400">{{ $ticket->service->name }}</p>
                                    <p class="text-xs text-gray-500">Temps estimé: {{ $ticket->service->estimated_time }}
                                        minutes</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if ($ticket->status === 'waiting' && $position)
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Position dans la file</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>Vous êtes <strong
                                                class="text-2xl">{{ $position }}</strong>{{ $position === 1 ? 'er' : 'ème' }}
                                            dans la file d'attente</p>
                                        <p class="mt-1 text-xs">
                                            Temps d'attente estimé:
                                            <strong>{{ ($position - 1) * $ticket->service->estimated_time }}
                                                minutes</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Historique</h3>
                        <div class="space-y-2">
                            <div class="flex items-center text-sm">
                                <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-600">Créé le {{ $ticket->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                            @if ($ticket->called_at)
                                <div class="flex items-center text-sm">
                                    <svg class="h-4 w-4 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                        </path>
                                    </svg>
                                    <span class="text-blue-600">Appelé le
                                        {{ $ticket->called_at->format('d/m/Y à H:i') }}</span>
                                </div>
                            @endif
                            @if ($ticket->completed_at)
                                <div class="flex items-center text-sm">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-green-600">Terminé le
                                        {{ $ticket->completed_at->format('d/m/Y à H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>


                    @if ($ticket->status === 'waiting')
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-neutral-400 mb-2">Instructions</h3>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Veuillez vous présenter à l'institution avec ce ticket</li>
                                <li>• Surveillez votre position dans la file d'attente</li>
                                <li>• Présentez-vous rapidement lorsque votre ticket sera appelé</li>
                            </ul>
                        </div>
                    @elseif($ticket->status === 'called')
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">🔔 Votre ticket a été appelé !</h3>
                            <p class="text-sm text-blue-700">Veuillez vous présenter immédiatement au guichet de service.
                            </p>
                        </div>
                    @endif
                </div>


                <div class="mt-8 flex justify-center space-x-4">
                    <a href="{{ route('user.dashboard') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        ← Retour au Tableau de Bord
                    </a>
                    @if ($ticket->status === 'waiting')
                        <button onclick="window.location.reload()"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Actualiser
                        </button>
                    @endif
                </div>
            </div>
        </div>


        @if ($ticket->status === 'waiting')
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-500">
                    💡 Astuce: Rafraîchissez cette page régulièrement pour voir votre position mise à jour
                </p>
            </div>
        @endif
    </div>
@endsection
