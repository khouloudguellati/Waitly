<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\User;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_institutions' => Institution::count(),
            'active_institutions' => Institution::where('is_active', true)->count(),
            'total_admins' => User::where('role', 'institution_admin')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_tickets_today' => Ticket::whereDate('created_at', today())->count(),
            'waiting_tickets' => Ticket::where('status', 'waiting')->count(),
        ];

        $recent_institutions = Institution::latest()->take(5)->get();
        $recent_tickets = Ticket::with(['user', 'institution', 'service'])
            ->latest()
            ->take(10)
            ->get();

        return view('super-admin.dashboard', compact('stats', 'recent_institutions', 'recent_tickets'));
    }
}
