<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Lead;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotographerController extends Controller
{
    /**
     * Dashboard fotografo
     */
    public function dashboard()
    {
        $photographer = auth()->user();

        $stats = [
            'active_events' => Event::where('photographer_id', $photographer->id)
                                   ->where('status', 'ongoing')
                                   ->count(),
            'total_leads' => Lead::where('photographer_id', $photographer->id)->count(),
            'total_photos' => Photo::where('uploaded_by', $photographer->id)->count(),
            'planned_events' => Event::where('photographer_id', $photographer->id)
                                    ->where('status', 'planned')
                                    ->count(),
        ];

        $current_events = Event::where('photographer_id', $photographer->id)
                              ->where('status', 'ongoing')
                              ->with('leads')
                              ->get();

        $recent_leads = Lead::where('photographer_id', $photographer->id)
                           ->with(['event', 'photos'])
                           ->latest()
                           ->limit(10)
                           ->get();

        return view('photographer.dashboard', compact('stats', 'current_events', 'recent_leads'));
    }

    /**
     * Lista eventi del fotografo
     */
    public function events()
    {
        $photographer = auth()->user();
        
        $events = Event::where('photographer_id', $photographer->id)
                      ->with('leads')
                      ->latest()
                      ->paginate(15);

        return view('photographer.events.index', compact('events'));
    }

    /**
     * Dettaglio evento
     */
    public function eventDetail(Event $event)
    {
        // Verifica che l'evento appartenga al fotografo loggato
        if ($event->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato ad accedere a questo evento');
        }

        $event->load(['leads.photos']);
        
        return view('photographer.events.detail', compact('event'));
    }
}
