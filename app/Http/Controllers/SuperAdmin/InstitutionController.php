<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::withCount(['services', 'tickets', 'admins'])
            ->latest()
            ->paginate(15);

        return view('super-admin.institutions.index', compact('institutions'));
    }

    public function create()
    {
        return view('super-admin.institutions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name'        => ['required', 'string', 'max:255'],
                'type'        => ['required', 'in:mairie,hopital,bureau_gouvernemental,autre'],
                'address'     => ['required', 'string'],
                'city'        => ['required', 'string', 'max:255'],
                'phone'       => ['required', 'string', 'max:20'],
                'email'       => ['nullable', 'email', 'max:255'],
                'description' => ['nullable', 'string'],
            ],
            [
                'name.required'    => 'Le nom est obligatoire.',
                'type.required'    => 'Le type est obligatoire.',
                'address.required' => 'L\'adresse est obligatoire.',
                'city.required'    => 'La ville est obligatoire.',
                'phone.required'   => 'Le téléphone est obligatoire.',
            ]
        );

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = true;

        Institution::create($validated);

        return redirect()
            ->route('super-admin.institutions.index')
            ->with('success', 'L\'institution a été créée avec succès.');
    }

    public function edit(Institution $institution)
    {
        return view('super-admin.institutions.edit', compact('institution'));
    }

    public function update(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:mairie,hopital,bureau_gouvernemental,autre'],
            'address'     => ['required', 'string'],
            'city'        => ['required', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['required', 'boolean'],
        ]);

        if ($validated['name'] !== $institution->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $institution->update($validated);

        return redirect()
            ->route('super-admin.institutions.index')
            ->with('success', 'L\'institution a été mise à jour avec succès.');
    }

    public function destroy(Institution $institution)
    {
        $activeTickets = $institution->tickets()
            ->where('status', 'waiting')
            ->count();

        if ($activeTickets > 0) {
            return back()->with(
                'error',
                'Impossible de supprimer cette institution. Il y a des tickets en attente.'
            );
        }

        $institution->delete();

        return redirect()
            ->route('super-admin.institutions.index')
            ->with('success', 'L\'institution a été supprimée avec succès.');
    }
}
