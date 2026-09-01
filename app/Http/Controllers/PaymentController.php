<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * Crea la sessione di pagamento Stripe al momento del click e
     * reindirizza il cliente alla pagina di pagamento ospitata da Stripe.
     * La sessione viene creata "on demand" cosi il link email/QR
     * condiviso dal fotografo resta valido anche a distanza di giorni,
     * senza scontrarsi con la scadenza breve delle sessioni Stripe.
     */
    public function show(Request $request, Order $order)
    {
        if ($order->payment_status === 'paid') {
            return redirect()->route('payment.success', $order);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'customer_email' => $order->lead->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => (int) round($order->amount * 100),
                    'product_data' => [
                        'name' => "Servizio fotografico - {$order->event->name}",
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'order_id' => $order->id,
            ],
            'success_url' => route('payment.success', $order),
            'cancel_url' => route('payment.cancel', $order),
        ]);

        $order->update(['stripe_checkout_session_id' => $session->id]);

        return redirect($session->url);
    }

    public function success(Order $order)
    {
        return view('payment.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        return view('payment.cancel', compact('order'));
    }
}
