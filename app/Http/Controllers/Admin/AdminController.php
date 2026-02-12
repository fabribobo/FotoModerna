<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard amministratore
     */
    public function dashboard()
    {
        $stats = [
            'total_leads' => Lead::count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'total_photos' => Photo::count(),
            'active_events' => Event::where('status', 'ongoing')->count(),
        ];

        $recent_leads = Lead::with(['event', 'photographer'])
                           ->latest()
                           ->limit(10)
                           ->get();

        $pending_orders = Order::with(['lead', 'event'])
                              ->where('payment_status', 'pending')
                              ->latest()
                              ->limit(5)
                              ->get();

        return view('admin.dashboard', compact('stats', 'recent_leads', 'pending_orders'));
    }

    /**
     * Lista di tutti i lead
     */
    public function leads()
    {
        $leads = Lead::with(['event', 'photographer', 'photos'])
                    ->latest()
                    ->paginate(20);

        return view('admin.leads.index', compact('leads'));
    }

    /**
     * Dettaglio di un lead
     */
    public function leadDetail(Lead $lead)
    {
        $lead->load(['event', 'photographer', 'photos', 'order']);
        
        return view('admin.leads.detail', compact('lead'));
    }

    /**
     * Gallery di tutte le foto
     */
    public function photos()
    {
        $photos = Photo::with(['lead', 'event', 'uploader'])
                      ->latest()
                      ->paginate(30);

        return view('admin.photos.index', compact('photos'));
    }
}
