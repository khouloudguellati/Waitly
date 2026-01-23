@extends('layouts.app')

@section('title', 'Réserver un Ticket')

@section('content')
    <div class="max-w-3xl py-5 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                <h1 class="text-3xl font-bold text-white text-center">Confirmer votre Réservation</h1>
            </div>


            <div class="px-6 py-6">
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-neutral-400 mb-4">Détails du Service</h2>

                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 h-6 w-6 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-500">Institution</p>
                                <p class="text-base font-semibold text-neutral-400">{{ $service->institution->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="flex-shrink-0 h-6 w-6 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-500">Service</p>
                                <p class="text-base font-semibold text-neutral-400">{{ $service->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <svg class="flex-shrink-0 h-6 w-6 text-gray-400 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-500">Temps d'attente estimé</p>
                                <p class="text-base font-semibold text-neutral-400">{{ $estimatedWait }} minutes</p>
                                <p class="text-xs text-gray-500">{{ $queueCount }} personne(s) en attente</p>
                            </div>
                        </div>
                    </div>
                </div>


                <form action="{{ route('user.tickets.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Rappel:</strong> Présentez-vous à l'institution avec ce ticket.
                                    Vous recevrez un numéro unique pour suivre votre position dans la file d'attente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('user.institutions.show', $service->institution) }}"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Confirmer la Réservation
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
