<?php

namespace App\Http\Controllers\Photographer;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Form per incassare il servizio il giorno dell'evento
     */
    public function create(Lead $lead)
    {
        $this->authorizeLead($lead);

        if ($lead->order) {
            return redirect()
                   ->route('photographer.leads.show', $lead)
                   ->with('error', 'Questo lead ha già un ordine associato');
        }

        return view('photographer.orders.create', compact('lead'));
    }

    /**
     * Crea l'ordine: incasso immediato in contanti oppure link di
     * pagamento Stripe da inviare al cliente (anche per pagare nei giorni successivi)
     */
    public function store(Request $request, Lead $lead)
    {
        $this->authorizeLead($lead);

        if ($lead->order) {
            return redirect()
                   ->route('photographer.leads.show', $lead)
                   ->with('error', 'Questo lead ha già un ordine associato');
        }

        $validated = $request->validate([
            'service_type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,stripe',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'lead_id' => $lead->id,
            'event_id' => $lead->event_id,
            'service_type' => $validated['service_type'],
            'amount' => $validated['amount'],
            'notes' => $validated['notes'],
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        if ($validated['payment_method'] === 'cash') {
            $order->markAsPaid();
            $order->sendDownloadEmail();

            return redirect()
                   ->route('photographer.leads.show', $lead)
                   ->with('success', 'Pagamento in contanti registrato. Email con il link di download inviata al cliente.');
        }

        $order->sendPaymentLinkEmail();

        return redirect()
               ->route('photographer.leads.show', $lead)
               ->with('success', 'Ordine creato. Link di pagamento inviato via email al cliente.')
               ->with('paymentUrl', $order->getPaymentUrl());
    }

    /**
     * Verifica che il lead appartenga al fotografo loggato
     */
    private function authorizeLead(Lead $lead): void
    {
        if ($lead->photographer_id !== auth()->id()) {
            abort(403, 'Non autorizzato ad accedere a questo lead');
        }
    }
}
