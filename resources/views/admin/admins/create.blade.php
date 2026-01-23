@extends('layouts.super-admin')

@section('title', 'Créer Administrateur')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg px-6 py-6">
            <h3 class="text-lg font-medium mb-6">Créer un Administrateur d'Institution</h3>

            <form action="{{ route('super-admin.admins.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Nom *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('email')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Téléphone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Institution *</label>
                        <select name="institution_id" required
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="">Choisir une institution</option>
                            @foreach ($institutions as $inst)
                                <option value="{{ $inst->id }}"
                                    {{ old('institution_id') == $inst->id ? 'selected' : '' }}>
                                    {{ $inst->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Mot de passe *</label>
                        <input type="password" name="password" required
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                        @error('password')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('super-admin.admins.index') }}" class="px-4 py-2 border rounded">Annuler</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-800 text-white rounded-md">Créer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
