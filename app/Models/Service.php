<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'institution_id',
        'name',
        'description',
        'estimated_time',
        'is_active',
        'daily_capacity',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'estimated_time' => 'integer',
        'daily_capacity' => 'integer',
    ];

    // Relations
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function getNextTicketNumber(): int
    {
        $lastTicket = $this->tickets()
            ->whereDate('created_at', today())
            ->orderBy('ticket_number', 'desc')
            ->first();

        return $lastTicket ? $lastTicket->ticket_number + 1 : 1;
    }

    public function getCurrentQueueCount(): int
    {
        return $this->tickets()
            ->whereDate('created_at', today())
            ->where('status', 'waiting')
            ->count();
    }
}
