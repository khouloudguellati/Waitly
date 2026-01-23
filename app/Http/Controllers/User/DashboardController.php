<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_tickets' => $user->tickets()->count(),
            'waiting_tickets' => $user->tickets()->where('status', 'waiting')->count(),
            'completed_tickets' => $user->tickets()->where('status', 'completed')->count(),
        ];

        $active_tickets = $user->tickets()
            ->with(['institution', 'service'])
            ->whereIn('status', ['waiting', 'called'])
            ->latest()
            ->get();

        $recent_tickets = $user->tickets()
            ->with(['institution', 'service'])
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'active_tickets', 'recent_tickets'));
    }
}
