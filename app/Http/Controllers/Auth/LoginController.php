<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Aucun compte ne correspond à cette adresse e-mail.',
            ])->withInput($request->only('email'));
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Votre compte a été désactivé. Veuillez contacter l\'administrateur.',
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification ne correspondent pas à nos enregistrements.',
        ])->withInput($request->only('email'));
    }

    protected function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return redirect()->intended(route('super-admin.dashboard'))
                ->with('success', 'Bienvenue, Super Administrateur !');
        }

        if ($user->isInstitutionAdmin()) {
            return redirect()->intended(route('institution-admin.dashboard'))
                ->with('success', 'Bienvenue, ' . $user->name . ' !');
        }

        return redirect()->intended(route('user.dashboard'))
            ->with('success', 'Bienvenue, ' . $user->name . ' !');
    }
}
