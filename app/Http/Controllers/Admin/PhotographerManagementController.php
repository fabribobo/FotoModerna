<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PhotographerManagementController extends Controller
{
    /**
     * Display a listing of photographers
     */
    public function index()
    {
        $photographers = User::role('fotografo')
            ->withCount(['events', 'leads'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.photographers.index', compact('photographers'));
    }

    /**
     * Show the form for creating a new photographer
     */
    public function create()
    {
        return view('admin.photographers.create');
    }

    /**
     * Store a newly created photographer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assegna il ruolo fotografo
        $user->assignRole('fotografo');

        return redirect()
            ->route('admin.photographers.index')
            ->with('success', 'Fotografo creato con successo!');
    }

    /**
     * Display the specified photographer
     */
    public function show(User $photographer)
    {
        // Carica le relazioni
        $photographer->load(['events', 'leads']);
        $photographer->loadCount(['events', 'leads', 'photos']);

        return view('admin.photographers.show', compact('photographer'));
    }

    /**
     * Show the form for editing the specified photographer
     */
    public function edit(User $photographer)
    {
        return view('admin.photographers.edit', compact('photographer'));
    }

    /**
     * Update the specified photographer
     */
    public function update(Request $request, User $photographer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $photographer->id],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $photographer->name = $validated['name'];
        $photographer->email = $validated['email'];

        // Aggiorna password solo se fornita
        if (!empty($validated['password'])) {
            $photographer->password = Hash::make($validated['password']);
        }

        $photographer->save();

        return redirect()
            ->route('admin.photographers.index')
            ->with('success', 'Fotografo aggiornato con successo!');
    }

    /**
     * Remove the specified photographer
     */
    public function destroy(User $photographer)
    {
        // Verifica che l'utente sia effettivamente un fotografo
        if (!$photographer->hasRole('fotografo')) {
            return redirect()
                ->route('admin.photographers.index')
                ->with('error', 'Impossibile eliminare: l\'utente non è un fotografo.');
        }

        // Verifica se ha eventi assegnati
        $eventsCount = $photographer->events()->count();
        if ($eventsCount > 0) {
            return redirect()
                ->route('admin.photographers.index')
                ->with('error', "Impossibile eliminare: il fotografo ha {$eventsCount} eventi assegnati.");
        }

        $photographer->delete();

        return redirect()
            ->route('admin.photographers.index')
            ->with('success', 'Fotografo eliminato con successo.');
    }
}
