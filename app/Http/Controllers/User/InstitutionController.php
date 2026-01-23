<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Institution;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::active()
            ->withCount('services')
            ->get();

        return view('user.institutions.index', compact('institutions'));
    }

    public function show(Institution $institution)
    {
        if (!$institution->is_active) {
            abort(404);
        }

        $services = $institution->services()
            ->active()
            ->withCount(['tickets as waiting_count' => function ($query) {
                $query->where('status', 'waiting');
            }])
            ->get();

        return view('user.institutions.show', compact('institution', 'services'));
    }
}
