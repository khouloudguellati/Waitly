<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function create(Service $service)
    {
        if (!$service->is_active) {
            abort(404);
        }

        $queueCount = $service->getCurrentQueueCount();
        $estimatedWait = $queueCount * $service->estimated_time;

        return view('user.tickets.create', compact('service', 'queueCount', 'estimatedWait'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
        ]);

        $service = Service::findOrFail($request->service_id);

        if (!$service->is_active) {
            return back()->with('error', 'Ce service n\'est pas disponible actuellement.');
        }

        $existingTicket = auth()->user()->tickets()
            ->where('service_id', $service->id)
            ->whereDate('created_at', today())
            ->whereIn('status', ['waiting', 'called'])
            ->first();

        if ($existingTicket) {
            return redirect()->route('user.tickets.show', $existingTicket)
                ->with('info', 'Vous avez déjà un ticket en attente pour ce service.');
        }

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'institution_id' => $service->institution_id,
            'service_id' => $service->id,
            'ticket_number' => $service->getNextTicketNumber(),
            'status' => 'waiting',
        ]);

        return redirect()->route('user.tickets.show', $ticket)
            ->with('success', 'Votre ticket a été créé avec succès !');
    }

    public function myTickets()
    {
        $tickets = auth()->user()->tickets()
            ->with(['institution', 'service'])
            ->latest()
            ->paginate(15);

        return view('user.tickets.my-tickets', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $position = $ticket->status === 'waiting' ? $ticket->getPositionInQueue() : null;

        return view('user.tickets.show', compact('ticket', 'position'));
    }
}
