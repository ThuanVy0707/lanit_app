<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientCustomField extends Model
{
    /** @use HasFactory<\Database\Factories\ClientCustomFieldFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'field_name',
        'value',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
