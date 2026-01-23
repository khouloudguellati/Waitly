@extends('layouts.app')

@section('title', 'Mes Tickets')

@section('content')
    <div class="max-w-7xl py-5 mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-400">Mes Tickets</h1>
            <p class="mt-2 text-sm text-gray-600">Historique complet de vos réservations</p>
        </div>


        <div class="mb-6 flex space-x-2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                Tous ({{ $tickets->total() }})
            </span>
        </div>


        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                    <li>
                        <a href="{{ route('user.tickets.show', $ticket) }}"
                            class="block hover:bg-gray-50 transition duration-150">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">

                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-14 w-14 rounded-lg {{ $ticket->status === 'waiting'
                                                    ? 'bg-yellow-100 border-2 border-yellow-400'
                                                    : ($ticket->status === 'called'
                                                        ? 'bg-blue-500 border-2 border-blue-600'
                                                        : ($ticket->status === 'completed'
                                                            ? 'bg-green-100 border-2 border-green-400'
                                                            : 'bg-red-100 border-2 border-red-400')) }} flex items-center justify-center">
                                                <span
                                                    class="text-xl font-bold {{ $ticket->status === 'waiting'
                                                        ? 'text-yellow-800'
                                                        : ($ticket->status === 'called'
                                                            ? 'text-white'
                                                            : ($ticket->status === 'completed'
                                                                ? 'text-green-800'
                                                                : 'text-red-800')) }}">
                                                    {{ $ticket->ticket_number }}
                                                </span>
                                            </div>
                                        </div>


                                        <div class="ml-4">
                                            <div class="flex items-center">
                                                <p class="text-lg font-semibold text-neutral-400">
                                                    Ticket #{{ $ticket->getFormattedTicketNumber() }}
                                                </p>
                                                <span
                                                    class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status === 'waiting'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($ticket->status === 'called'
                                                            ? 'bg-blue-100 text-blue-800'
                                                            : ($ticket->status === 'completed'
                                                                ? 'bg-green-100 text-green-800'
                                                                : 'bg-red-100 text-red-800')) }}">
                                                    @if ($ticket->status === 'waiting')
                                                        En Attente
                                                    @elseif($ticket->status === 'called')
                                                        Appelé
                                                    @elseif($ticket->status === 'completed')
                                                        Terminé
                                                    @else
                                                        Annulé
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                {{ $ticket->institution->name }}
                                            </div>
                                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ $ticket->service->name }}
                                            </div>
                                            <div class="mt-1 flex items-center text-xs text-gray-400">
                                                <svg class="flex-shrink-0 mr-1.5 h-3 w-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                {{ $ticket->created_at->format('d/m/Y à H:i') }}
                                                <span class="mx-2">•</span>
                                                {{ $ticket->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="ml-4 flex-shrink-0">
                                        @if ($ticket->status === 'waiting' || $ticket->status === 'called')
                                            <div class="flex flex-col items-end">
                                                <span class="text-xs text-gray-500 mb-1">Voir détails</span>
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        @else
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>


                                @if ($ticket->status === 'called')
                                    <div class="mt-3 px-4 py-2 bg-blue-50 border-l-4 border-blue-400 rounded">
                                        <p class="text-sm text-blue-700">
                                            <strong>🔔 Votre ticket a été appelé !</strong> Présentez-vous au guichet de
                                            service.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </li>
                @empty
                    <li class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-neutral-400">Aucun ticket</h3>
                        <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore réservé de ticket.</p>
                        <div class="mt-6">
                            <a href="{{ route('user.institutions.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Réserver un Ticket
                            </a>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>


        @if ($tickets->hasPages())
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @endif


        <div class="mt-8">
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Retour au Tableau de Bord
            </a>
        </div>
    </div>
@endsection
