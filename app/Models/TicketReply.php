<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketReply extends Model
{
    /** @use HasFactory<\Database\Factories\TicketReplyFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_staff_reply' => 'boolean',
        ];
    }

    protected $fillable = [
        'ticket_id',
        'user_id',
        'client_id',
        'message',
        'is_staff_reply',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
