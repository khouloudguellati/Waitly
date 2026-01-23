@extends('layouts.institution-admin')

@section('title', 'Modifier le Service')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                    Modifier le Service
                </h3>

                <form action="{{ route('institution-admin.services.update', $service) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom du Service *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}"
                                required
                                class="mt-1 block w-full border @error('name') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description (optionnel)
                            </label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full border @error('description') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="estimated_time" class="block text-sm font-medium text-gray-700">
                                Temps Estimé par Ticket (en minutes) *
                            </label>
                            <input type="number" name="estimated_time" id="estimated_time"
                                value="{{ old('estimated_time', $service->estimated_time) }}" min="1" max="180"
                                required
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
                                value="{{ old('daily_capacity', $service->daily_capacity) }}" min="1"
                                class="mt-1 block w-full border @error('daily_capacity') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">Nombre maximum de tickets que ce service peut traiter par
                                jour</p>
                            @error('daily_capacity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">
                                    Service actif (les citoyens peuvent réserver des tickets)
                                </span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">
                                Désactivez temporairement le service sans le supprimer
                            </p>
                        </div>

                        
                        @if ($service->tickets()->where('status', 'waiting')->count() > 0)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            <strong>Attention:</strong> Ce service a actuellement
                                            {{ $service->tickets()->where('status', 'waiting')->count() }} ticket(s) en
                                            attente.
                                            Si vous désactivez le service, les citoyens ne pourront plus réserver de
                                            nouveaux tickets.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
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
                            Mettre à Jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
