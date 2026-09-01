<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Lista di tutti gli ordini
     */
    public function index()
    {
        $orders = Order::with(['lead', 'event'])
                      ->latest()
                      ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Crea un nuovo ordine per un lead
     */
    public function create(Lead $lead)
    {
        if ($lead->order) {
            return redirect()
                   ->back()
                   ->with('error', 'Questo lead ha già un ordine associato');
        }

        return view('admin.orders.create', compact('lead'));
    }

    /**
     * Salva un nuovo ordine
     */
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'service_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'lead_id' => $lead->id,
            'event_id' => $lead->event_id,
            'service_type' => $validated['service_type'],
            'amount' => $validated['amount'],
            'notes' => $validated['notes'],
            'payment_status' => 'pending',
        ]);

        return redirect()
               ->route('admin.orders.show', $order)
               ->with('success', 'Ordine creato con successo');
    }

    /**
     * Mostra dettagli ordine
     */
    public function show(Order $order)
    {
        $order->load(['lead', 'event']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Segna l'ordine come pagato e invia email
     */
    public function markAsPaid(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return redirect()
                   ->back()
                   ->with('error', 'Questo ordine è già stato segnato come pagato');
        }

        $order->payment_method = 'cash';
        $order->markAsPaid();

        // Invia email con link temporaneo
        $order->sendDownloadEmail();

        return redirect()
               ->back()
               ->with('success', 'Ordine segnato come pagato. Email inviata al cliente.');
    }
}
