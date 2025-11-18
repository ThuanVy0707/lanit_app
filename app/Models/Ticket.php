<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
