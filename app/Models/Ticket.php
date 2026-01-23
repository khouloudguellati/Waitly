<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'institution_id',
        'service_id',
        'ticket_number',
        'status',
        'called_at',
        'completed_at',
    ];

    protected $casts = [
        'called_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Scopes
    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Helper methods
    public function getPositionInQueue(): int
    {
        return $this->service->tickets()
            ->where('status', 'waiting')
            ->where('created_at', '<', $this->created_at)
            ->count() + 1;
    }

    public function getFormattedTicketNumber(): string
    {
        return sprintf('%s-%03d', strtoupper(substr($this->service->name, 0, 3)), $this->ticket_number);
    }
}
