@extends('layouts.super-admin')

@section('title', 'Nouvelle Institution')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
                    Créer une Nouvelle Institution
                </h3>

                <form action="{{ route('super-admin.institutions.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nom de l'Institution *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full border @error('name') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">
                                Type d'Institution *
                            </label>
                            <select name="type" id="type" required
                                class="mt-1 block w-full border @error('type') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Sélectionnez un type</option>
                                <option value="mairie" {{ old('type') === 'mairie' ? 'selected' : '' }}>Mairie</option>
                                <option value="hopital" {{ old('type') === 'hopital' ? 'selected' : '' }}>Hôpital</option>
                                <option value="bureau_gouvernemental"
                                    {{ old('type') === 'bureau_gouvernemental' ? 'selected' : '' }}>Bureau Gouvernemental
                                </option>
                                <option value="autre" {{ old('type') === 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">
                                Ville *
                            </label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                class="mt-1 block w-full border @error('city') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                Adresse *
                            </label>
                            <textarea name="address" id="address" rows="3" required
                                class="mt-1 block w-full border @error('address') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Téléphone *
                            </label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="mt-1 block w-full border @error('phone') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="+213 XX XX XX XX">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email (optionnel)
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 block w-full border @error('email') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description (optionnel)
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full border @error('description') border-red-300 @else border-gray-300 @enderror rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('super-admin.institutions.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Annuler
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-800 hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Créer l'Institution
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
