<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_id',
        'photographer_id',
        'notes',
        'status',
    ];

    /**
     * Evento associato al lead
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Fotografo che ha creato il lead
     */
    public function photographer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'photographer_id');
    }

    /**
     * Foto associate al lead
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Ordine del lead
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
