@extends('layouts.institution-admin')

@section('title', 'Gestion des Tickets - ' . $service->name)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $service->name }}</h2>
                    <p class="mt-1 text-sm text-gray-500">Gestion des tickets du jour</p>
                </div>
                <a href="{{ route('institution-admin.tickets.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    ← Retour aux services
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Aujourd'hui</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_today'] }}</dd>
                </div>
            </div>
            <div class="bg-yellow-50 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <dt class="text-sm font-medium text-yellow-700 truncate">En Attente</dt>
                    <dd class="mt-1 text-3xl font-semibold text-yellow-900">{{ $stats['waiting'] }}</dd>
                </div>
            </div>
            <div class="bg-blue-50 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <dt class="text-sm font-medium text-blue-700 truncate">Appelés</dt>
                    <dd class="mt-1 text-3xl font-semibold text-blue-900">{{ $stats['called'] }}</dd>
                </div>
            </div>
            <div class="bg-green-50 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <dt class="text-sm font-medium text-green-700 truncate">Terminés</dt>
                    <dd class="mt-1 text-3xl font-semibold text-green-900">{{ $stats['completed'] }}</dd>
                </div>
            </div>
        </div>

        
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($tickets as $ticket)
                    <li class="{{ $ticket->status === 'called' ? 'bg-blue-50' : '' }}">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-16 w-16 rounded-lg {{ $ticket->status === 'waiting'
                                                ? 'bg-yellow-100 border-2 border-yellow-400'
                                                : ($ticket->status === 'called'
                                                    ? 'bg-blue-500 border-2 border-blue-600'
                                                    : ($ticket->status === 'completed'
                                                        ? 'bg-green-100 border-2 border-green-400'
                                                        : 'bg-red-100 border-2 border-red-400')) }} flex items-center justify-center">
                                            <span
                                                class="text-2xl font-bold {{ $ticket->status === 'waiting'
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
                                        <div class="text-sm font-medium text-gray-900">
                                            Ticket #{{ $ticket->getFormattedTicketNumber() }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $ticket->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            Créé à {{ $ticket->created_at->format('H:i') }}
                                            @if ($ticket->called_at)
                                                • Appelé à {{ $ticket->called_at->format('H:i') }}
                                            @endif
                                            @if ($ticket->completed_at)
                                                • Terminé à {{ $ticket->completed_at->format('H:i') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="flex items-center space-x-2">
                                    @if ($ticket->status === 'waiting')
                                        <form action="{{ route('institution-admin.tickets.call', $ticket) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                                    </path>
                                                </svg>
                                                Appeler
                                            </button>
                                        </form>
                                        <form action="{{ route('institution-admin.tickets.cancel', $ticket) }}"
                                            method="POST"
                                            onsubmit="return confirm('Voulez-vous vraiment annuler ce ticket ?');">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                                Annuler
                                            </button>
                                        </form>
                                    @elseif($ticket->status === 'called')
                                        <form action="{{ route('institution-admin.tickets.complete', $ticket) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Terminer
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $ticket->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ticket->status === 'completed' ? 'Terminé' : 'Annulé' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun ticket aujourd'hui</h3>
                        <p class="mt-1 text-sm text-gray-500">Les tickets apparaîtront ici lorsque les citoyens réserveront.
                        </p>
                    </li>
                @endforelse
            </ul>
        </div>

        
        @if ($tickets->hasPages())
            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
@endsection
