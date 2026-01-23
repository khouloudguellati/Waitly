<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstitutionAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        if (!$user->isInstitutionAdmin()) {
            abort(403, 'Accès non autorisé.');
        }

        if (!$user->institution) {
            abort(403, 'Vous n\'êtes associé à aucune institution.');
        }

        return $next($request);
    }
}
