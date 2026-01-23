@extends('layouts.super-admin')

@section('title', 'Administrateurs d\'Institutions')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between">
            <h2 class="text-2xl font-bold">Administrateurs</h2>
            <a href="{{ route('super-admin.admins.create') }}" class="px-4 py-2 bg-indigo-800 text-white rounded-md">
                + Nouvel Administrateur
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y">
                @foreach ($admins as $admin)
                    <li class="px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $admin->name }}</p>
                                <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                                <p class="text-xs text-gray-400">{{ $admin->institution->name }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('super-admin.admins.edit', $admin) }}"
                                    class="px-3 py-1 border rounded">Modifier</a>
                                <form action="{{ route('super-admin.admins.destroy', $admin) }}" method="POST"
                                    onsubmit="return confirm('Confirmer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 border border-red-300 text-red-700 rounded">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        {{ $admins->links() }}
    </div>
@endsection
