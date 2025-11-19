<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'ticket_number',
        'subject',
        'department',
        'priority',
        'status',
        'message',
        'merged_to_ticket_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function mergedTo(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'merged_to_ticket_id');
    }

    public function mergedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'merged_to_ticket_id');
    }
}
