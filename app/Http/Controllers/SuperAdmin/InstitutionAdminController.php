<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class InstitutionAdminController extends Controller
{
    public function index()
    {
        $admins = User::with('institution')
            ->where('role', 'institution_admin')
            ->latest()
            ->paginate(15);

        return view('super-admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $institutions = Institution::where('is_active', true)->get();
        return view('super-admin.admins.create', compact('institutions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'password' => ['required', Password::min(8)],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'institution_id.required' => 'L\'institution est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'institution_id' => $validated['institution_id'],
            'password' => Hash::make($validated['password']),
            'role' => 'institution_admin',
            'is_active' => true,
        ]);

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'L\'administrateur a été créé avec succès.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'institution_admin') {
            abort(404);
        }

        $institutions = Institution::where('is_active', true)->get();
        return view('super-admin.admins.edit', compact('user', 'institutions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'institution_id' => ['required', 'exists:institutions,id'],
            'password' => ['nullable', Password::min(8)],
            'is_active' => ['required', 'boolean'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'institution_id' => $validated['institution_id'],
            'is_active' => $validated['is_active'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'L\'administrateur a été mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'institution_admin') {
            abort(404);
        }

        $user->delete();

        return redirect()->route('super-admin.admins.index')
            ->with('success', 'L\'administrateur a été supprimé avec succès.');
    }
}
