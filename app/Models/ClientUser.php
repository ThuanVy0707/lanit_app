<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientUser extends Model
{
    /** @use HasFactory<\Database\Factories\ClientUserFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_owner' => 'boolean',
        ];
    }

    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'email',
        'is_owner',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
