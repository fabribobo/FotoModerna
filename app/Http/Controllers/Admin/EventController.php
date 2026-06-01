<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Lista eventi
     */
    public function index()
    {
        $events = Event::with(['photographer', 'photographers'])
                      ->withCount(['leads', 'photos'])
                      ->latest('event_date')
                      ->paginate(20);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Form creazione evento
     */
    public function create()
    {
        $photographers = User::role('fotografo')->orderBy('name')->get();
        
        return view('admin.events.create', compact('photographers'));
    }

    /**
     * Salva nuovo evento
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photographer_id' => 'nullable|exists:users,id',
            'status' => 'required|in:planned,ongoing,completed,cancelled',
            'photographers' => 'nullable|array',
            'photographers.*' => 'exists:users,id',
        ]);

        $event = Event::create([
            'name' => $validated['name'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'photographer_id' => $validated['photographer_id'],
            'status' => $validated['status'],
        ]);

        // Assegna fotografi multipli
        if (!empty($validated['photographers'])) {
            $event->photographers()->sync($validated['photographers']);
        }

        return redirect()
               ->route('admin.events.show', $event)
               ->with('success', 'Evento creato con successo');
    }

    /**
     * Mostra dettaglio evento
     */
    public function show(Event $event)
    {
        $event->load(['photographer', 'photographers', 'leads.photographer', 'photos']);
        
        return view('admin.events.show', compact('event'));
    }

    /**
     * Form modifica evento
     */
    public function edit(Event $event)
    {
        $photographers = User::role('fotografo')->orderBy('name')->get();
        $assignedPhotographers = $event->photographers->pluck('id')->toArray();
        
        return view('admin.events.edit', compact('event', 'photographers', 'assignedPhotographers'));
    }

    /**
     * Aggiorna evento
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photographer_id' => 'nullable|exists:users,id',
            'status' => 'required|in:planned,ongoing,completed,cancelled',
            'photographers' => 'nullable|array',
            'photographers.*' => 'exists:users,id',
        ]);

        $event->update([
            'name' => $validated['name'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'photographer_id' => $validated['photographer_id'],
            'status' => $validated['status'],
        ]);

        // Aggiorna fotografi assegnati
        if (isset($validated['photographers'])) {
            $event->photographers()->sync($validated['photographers']);
        } else {
            $event->photographers()->detach();
        }

        return redirect()
               ->route('admin.events.show', $event)
               ->with('success', 'Evento aggiornato con successo');
    }

    /**
     * Elimina evento
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
               ->route('admin.events.index')
               ->with('success', 'Evento eliminato con successo');
    }
}
