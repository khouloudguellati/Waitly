<?php

namespace App\Http\Controllers\InstitutionAdmin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $institution = auth()->user()->institution;

        $services = $institution->services()
            ->withCount(['tickets as waiting_count' => function ($query) {
                $query->where('status', 'waiting');
            }])
            ->where('is_active', true)
            ->get();

        return view('institution-admin.tickets.index', compact('services', 'institution'));
    }

    public function byService(Service $service)
    {
        if ($service->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        $tickets = $service->tickets()
            ->with('user')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        $stats = [
            'total_today' => $service->tickets()->whereDate('created_at', today())->count(),
            'waiting' => $service->tickets()->where('status', 'waiting')->count(),
            'called' => $service->tickets()->where('status', 'called')->count(),
            'completed' => $service->tickets()
                ->whereDate('created_at', today())
                ->where('status', 'completed')
                ->count(),
        ];

        return view('institution-admin.tickets.manage', compact('service', 'tickets', 'stats'));
    }

    public function call(Ticket $ticket)
    {
        if ($ticket->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        if ($ticket->status !== 'waiting') {
            return back()->with('error', 'Ce ticket n\'est pas en attente.');
        }

        $ticket->update([
            'status' => 'called',
            'called_at' => now(),
        ]);

        return back()->with('success', 'Le ticket #' . $ticket->getFormattedTicketNumber() . ' a été appelé.');
    }

    public function complete(Ticket $ticket)
    {
        if ($ticket->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        if (!in_array($ticket->status, ['waiting', 'called'])) {
            return back()->with('error', 'Ce ticket ne peut pas être marqué comme terminé.');
        }

        $ticket->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Le ticket #' . $ticket->getFormattedTicketNumber() . ' a été marqué comme terminé.');
    }

    public function cancel(Ticket $ticket)
    {
        if ($ticket->institution_id !== auth()->user()->institution_id) {
            abort(403);
        }

        if (!in_array($ticket->status, ['waiting', 'called'])) {
            return back()->with('error', 'Ce ticket ne peut pas être annulé.');
        }

        $ticket->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Le ticket #' . $ticket->getFormattedTicketNumber() . ' a été annulé.');
    }
}
