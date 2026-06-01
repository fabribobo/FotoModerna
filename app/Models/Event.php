<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'event_date',
        'location',
        'description',
        'photographer_id',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    /**
     * Fotografo principale assegnato all'evento
     */
    public function photographer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'photographer_id');
    }

    /**
     * Tutti i fotografi assegnati all'evento (relazione many-to-many)
     */
    public function photographers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')
                    ->withTimestamps();
    }

    /**
     * Lead associati all'evento
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    /**
     * Foto dell'evento
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Ordini dell'evento
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
