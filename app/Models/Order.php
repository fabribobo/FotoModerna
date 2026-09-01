<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'lead_id',
        'event_id',
        'service_type',
        'amount',
        'payment_status',
        'payment_method',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'paid_at',
        'download_token',
        'download_expires_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'download_expires_at' => 'datetime',
    ];

    /**
     * Lead associato all'ordine
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Evento associato all'ordine
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Genera un token di download e imposta la scadenza
     */
    public function generateDownloadToken(): void
    {
        $this->download_token = Str::random(64);
        $this->download_expires_at = now()->addDays(30);
        $this->save();
    }

    /**
     * Genera l'URL temporaneo per il download
     */
    public function getDownloadUrl(): string
    {
        return URL::temporarySignedRoute(
            'download.gallery',
            $this->download_expires_at,
            ['token' => $this->download_token]
        );
    }

    /**
     * Verifica se il link di download è ancora valido
     */
    public function isDownloadValid(): bool
    {
        return $this->download_token && 
               $this->download_expires_at && 
               now()->lessThan($this->download_expires_at);
    }

    /**
     * Segna l'ordine come pagato e genera il token
     */
    public function markAsPaid(): void
    {
        $this->payment_status = 'paid';
        $this->paid_at = now();
        $this->generateDownloadToken();
        $this->save();
    }

    /**
     * Genera l'URL firmato per il pagamento online (valido 30 giorni,
     * cosi il cliente puo pagare anche nei giorni successivi all'evento)
     */
    public function getPaymentUrl(): string
    {
        return URL::temporarySignedRoute(
            'payment.pay',
            now()->addDays(30),
            ['order' => $this->id]
        );
    }

    /**
     * Invia l'email con il link per il download delle foto
     */
    public function sendDownloadEmail(): void
    {
        Mail::send('emails.download-link', [
            'leadName' => $this->lead->name,
            'eventName' => $this->event->name,
            'downloadUrl' => $this->getDownloadUrl(),
            'expiresAt' => $this->download_expires_at->format('d/m/Y'),
        ], function ($message) {
            $message->to($this->lead->email)
                    ->subject("Le tue foto dell'evento: {$this->event->name}");
        });
    }

    /**
     * Invia l'email con il link per pagare online (utile se il cliente
     * preferisce pagare nei giorni successivi all'evento)
     */
    public function sendPaymentLinkEmail(): void
    {
        Mail::send('emails.payment-link', [
            'leadName' => $this->lead->name,
            'eventName' => $this->event->name,
            'amount' => $this->amount,
            'paymentUrl' => $this->getPaymentUrl(),
        ], function ($message) {
            $message->to($this->lead->email)
                    ->subject("Completa il pagamento per l'evento: {$this->event->name}");
        });
    }
}
