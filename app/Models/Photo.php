<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'disk',
        'mime_type',
        'size',
        'metadata',
        'lead_id',
        'event_id',
        'uploaded_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Lead associato alla foto
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Evento associato alla foto
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Utente che ha caricato la foto
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * URL per accedere alla foto
     */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * URL per il download della foto
     */
    public function getDownloadUrlAttribute(): string
    {
        return Storage::disk($this->disk)->temporaryUrl($this->path, now()->addHours(1));
    }
}
