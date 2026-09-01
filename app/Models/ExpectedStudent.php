<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpectedStudent extends Model
{
    protected $fillable = [
        'event_id',
        'matricola',
        'name',
        'matched_lead_id',
    ];

    /**
     * Evento a cui si riferisce la matricola attesa
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Lead creato quando lo studente si è presentato all'evento
     */
    public function matchedLead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'matched_lead_id');
    }
}
