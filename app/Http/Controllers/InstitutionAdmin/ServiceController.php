<?php

namespace App\Http\Controllers\InstitutionAdmin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $institution = auth()->user()->institution;

        $services = $institution->services()
            ->withCount(['tickets as today_tickets' => function ($query) {
                $query->whereDate('created_at', today());
            }])
            ->withCount(['tickets as waiting_tickets' => function ($query) {
                $query->where('status', 'waiting');
            }])
            ->latest()
            ->paginate(15);

        return view('institution-admin.services.index', compact('services', 'institution'));
    }

    public function create()
    {
        return view('institution-admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'estimated_time' => ['required', 'integer', 'min:1', 'max:180'],
            'daily_capacity' => ['nullable', 'integer', 'min:1'],
        ], [
            'name.required' => 'Le nom du service est obligatoire.',
            'estimated_time.required' => 'Le temps estimé est obligatoire.',
            'estimated_time.min' => 'Le temps estimé doit être au moins 1 minute.',
        ]);

        $validated['institution_id'] = auth()->user()->institution_id;
        $validated['is_active'] = true;

        Service::create($validated);

        return redirect()->route('institution-admin.services.index')
            ->with('success', 'Le service a été créé avec succès.');
    }

    public function edit(Service $service)
    {
        if ($service->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        return view('institution-admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        if ($service->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'estimated_time' => ['required', 'integer', 'min:1', 'max:180'],
            'daily_capacity' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ]);

        $service->update($validated);

        return redirect()->route('institution-admin.services.index')
            ->with('success', 'Le service a été mis à jour avec succès.');
    }

    public function destroy(Service $service)
    {
        if ($service->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        $waitingTickets = $service->tickets()->where('status', 'waiting')->count();

        if ($waitingTickets > 0) {
            return back()->with('error', 'Impossible de supprimer ce service. Il y a des tickets en attente.');
        }

        $service->delete();

        return redirect()->route('institution-admin.services.index')
            ->with('success', 'Le service a été supprimé avec succès.');
    }
}
