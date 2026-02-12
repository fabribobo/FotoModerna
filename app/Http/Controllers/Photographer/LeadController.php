<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Lista lead del fotografo
     */
    public function index()
    {
        $photographer = auth()->user();
        
        $leads = Lead::where('photographer_id', $photographer->id)
                    ->with(['event', 'photos'])
                    ->latest()
                    ->paginate(20);

        return view('photographer.leads.index', compact('leads'));
    }

    /**
     * Form per creare nuovo lead
     */
    public function create(Event $event = null)
    {
        $photographer = auth()->user();
        
        // Se non viene specificato un evento, prendi quelli attivi del fotografo
        $events = Event::where('photographer_id', $photographer->id)
                      ->whereIn('status', ['planned', 'ongoing'])
                      ->get();

        return view('photographer.leads.create', compact('event', 'events'));
    }

    /**
     * Salva nuovo lead
     */
    public function store(Request $request)
    {
        $photographer = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'event_id' => 'required|exists:events,id',
            'notes' => 'nullable|string',
        ]);

        // Verifica che l'evento appartenga al fotografo
        $event = Event::where('id', $validated['event_id'])
                     ->where('photographer_id', $photographer->id)
                     ->firstOrFail();

        $lead = Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'event_id' => $validated['event_id'],
            'photographer_id' => $photographer->id,
            'notes' => $validated['notes'],
        ]);

        return redirect()
               ->route('photographer.leads.show', $lead)
               ->with('success', 'Lead creato con successo');
    }

    /**
     * Mostra dettaglio lead
     */
    public function show(Lead $lead)
    {
        // Verifica che il lead appartenga al fotografo loggato
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato ad accedere a questo lead');
        }

        $lead->load(['event', 'photos']);
        
        return view('photographer.leads.show', compact('lead'));
    }

    /**
     * Form per modificare lead
     */
    public function edit(Lead $lead)
    {
        // Verifica che il lead appartenga al fotografo loggato
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato ad modificare questo lead');
        }

        $photographer = auth()->user();
        
        $events = Event::where('photographer_id', $photographer->id)
                      ->whereIn('status', ['planned', 'ongoing'])
                      ->get();

        return view('photographer.leads.edit', compact('lead', 'events'));
    }

    /**
     * Aggiorna lead
     */
    public function update(Request $request, Lead $lead)
    {
        // Verifica che il lead appartenga al fotografo loggato
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato ad aggiornare questo lead');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $lead->update($validated);

        return redirect()
               ->route('photographer.leads.show', $lead)
               ->with('success', 'Lead aggiornato con successo');
    }
}
