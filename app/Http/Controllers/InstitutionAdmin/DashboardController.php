<?php

namespace App\Http\Controllers\InstitutionAdmin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $institution = $user->institution;

        $stats = [
            'total_services' => $institution->services()->count(),
            'active_services' => $institution->services()->where('is_active', true)->count(),
            'tickets_today' => $institution->tickets()->whereDate('created_at', today())->count(),
            'waiting_tickets' => $institution->tickets()->where('status', 'waiting')->count(),
            'completed_today' => $institution->tickets()
                ->whereDate('created_at', today())
                ->where('status', 'completed')
                ->count(),
        ];

        $services_with_queue = $institution->services()
            ->withCount(['tickets as waiting_count' => function ($query) {
                $query->where('status', 'waiting');
            }])
            ->where('is_active', true)
            ->get();

        $recent_tickets = $institution->tickets()
            ->with(['user', 'service'])
            ->latest()
            ->take(10)
            ->get();

        return view('institution-admin.dashboard', compact(
            'stats',
            'institution',
            'services_with_queue',
            'recent_tickets'
        ));
    }
}
