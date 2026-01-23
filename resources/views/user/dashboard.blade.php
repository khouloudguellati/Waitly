@extends('layouts.app')

@section('title', 'Mon Tableau de Bord')

@section('content')
    <div class="max-w-7xl py-5 mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-400">Tableau de Bord</h1>
            <p class="mt-2 text-sm text-gray-600">Bienvenue, {{ auth()->user()->name }}</p>
        </div>


        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Tickets</dt>
                                <dd class="text-3xl font-semibold text-neutral-400">{{ $stats['total_tickets'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">En Attente</dt>
                                <dd class="text-3xl font-semibold text-yellow-600">{{ $stats['waiting_tickets'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Terminés</dt>
                                <dd class="text-3xl font-semibold text-green-600">{{ $stats['completed_tickets'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="bg-gradient-to-r from-blue-500 to-indigo-900 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Réserver un nouveau ticket</h2>
                    <p class="mt-2 text-blue-100">Choisissez une institution et un service pour réserver votre place</p>
                </div>
                <div>
                    <a href="{{ route('user.institutions.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Réserver Maintenant
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>


        @if ($active_tickets->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-neutral-400 mb-4">Vos Tickets Actifs</h2>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($active_tickets as $ticket)
                            <li>
                                <a href="{{ route('user.tickets.show', $ticket) }}"
                                    class="block hover:bg-gray-50 transition duration-150">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <p class="text-2xl font-bold text-blue-600">
                                                    {{ $ticket->getFormattedTicketNumber() }}</p>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-neutral-400">
                                                        {{ $ticket->service->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $ticket->institution->name }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span
                                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if ($ticket->status === 'waiting') bg-yellow-100 text-yellow-800
                                                @elseif($ticket->status === 'called') bg-green-100 text-green-800 @endif">
                                                    @if ($ticket->status === 'waiting')
                                                        En Attente
                                                    @elseif($ticket->status === 'called')
                                                        Appelé
                                                    @endif
                                                </span>
                                                <svg class="ml-4 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif


        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-neutral-400">Historique Récent</h2>
                <a href="{{ route('user.tickets.my-tickets') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    Voir tout →
                </a>
            </div>

            @if ($recent_tickets->count() > 0)
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($recent_tickets as $ticket)
                            <li>
                                <a href="{{ route('user.tickets.show', $ticket) }}"
                                    class="block hover:bg-gray-50 transition duration-150">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <p class="text-lg font-bold text-gray-700">
                                                    {{ $ticket->getFormattedTicketNumber() }}</p>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-neutral-400">
                                                        {{ $ticket->service->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $ticket->institution->name }} •
                                                        {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if ($ticket->status === 'waiting') bg-yellow-100 text-yellow-800
                                                @elseif($ticket->status === 'called') bg-green-100 text-green-800
                                                @elseif($ticket->status === 'completed') bg-blue-100 text-blue-800
                                                @elseif($ticket->status === 'cancelled') bg-red-100 text-red-800 @endif">
                                                    @if ($ticket->status === 'waiting')
                                                        En Attente
                                                    @elseif($ticket->status === 'called')
                                                        Appelé
                                                    @elseif($ticket->status === 'completed')
                                                        Terminé
                                                    @elseif($ticket->status === 'cancelled')
                                                        Annulé
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-neutral-400">Aucun ticket</h3>
                        <p class="mt-1 text-sm text-gray-500">Commencez par réserver votre premier ticket.</p>
                        <div class="mt-6">
                            <a href="{{ route('user.institutions.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900">
                                Réserver un ticket
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
