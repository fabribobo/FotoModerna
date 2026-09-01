<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeWebhookController extends Controller
{
    /**
     * Riceve gli eventi Stripe. Il pagamento viene confermato solo qui
     * (mai dalla pagina di "success", che l'utente potrebbe raggiungere
     * senza aver completato davvero il pagamento).
     */
    public function handle(Request $request)
    {
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                $webhookSecret
            );
        } catch (SignatureVerificationException $e) {
            Log::warning('Firma webhook Stripe non valida', ['error' => $e->getMessage()]);

            return response('Invalid signature', Response::HTTP_BAD_REQUEST);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $order = Order::where('stripe_checkout_session_id', $session->id)
                          ->orWhere('id', $session->metadata->order_id ?? null)
                          ->first();

            if ($order && $order->payment_status !== 'paid') {
                $order->payment_method = 'stripe';
                $order->stripe_payment_intent_id = $session->payment_intent;
                $order->markAsPaid();
                $order->sendDownloadEmail();
            }
        }

        return response('OK', Response::HTTP_OK);
    }
}
