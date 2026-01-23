@extends('layouts.institution-admin')

@section('title', 'Nouveau Service')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                    Créer un Nouveau Service
                </h3>

                <form action="{{ route('institution-admin.services.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom du Service *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full border @error('name') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Ex: État Civil, Urbanisme, Consultation Générale...">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description (optionnel)
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full border @error('description') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Décrivez brièvement ce service...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="estimated_time" class="block text-sm font-medium text-gray-700">
                                Temps Estimé par Ticket (en minutes) *
                            </label>
                            <input type="number" name="estimated_time" id="estimated_time"
                                value="{{ old('estimated_time', 15) }}" min="1" max="180" required
                                class="mt-1 block w-full border @error('estimated_time') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Durée moyenne de traitement d'un ticket (1-180 minutes)
                            </p>
                            @error('estimated_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="daily_capacity" class="block text-sm font-medium text-gray-700">
                                Capacité Journalière (optionnel)
                            </label>
                            <input type="number" name="daily_capacity" id="daily_capacity"
                                value="{{ old('daily_capacity') }}" min="1"
                                class="mt-1 block w-full border @error('daily_capacity') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Ex: 50">
                            <p class="mt-1 text-xs text-gray-500">Nombre maximum de tickets que ce service peut traiter par
                                jour</p>
                            @error('daily_capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
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
                                    <p class="text-sm text-blue-700">
                                        <strong>Conseil:</strong> Un temps estimé précis aide les citoyens à planifier leur
                                        visite.
                                        La capacité journalière vous permet de limiter le nombre de tickets si nécessaire.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('institution-admin.services.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="mr-2 -ml-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Créer le Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
