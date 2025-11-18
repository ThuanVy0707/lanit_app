<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends Model
{
    /** @use HasFactory<\Database\Factories\DomainFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'registration_date' => 'date',
            'expiry_date' => 'date',
            'registration_price' => 'decimal:2',
            'renewal_price' => 'decimal:2',
        ];
    }

    protected $fillable = [
        'client_id',
        'domain_name',
        'status',
        'registration_date',
        'expiry_date',
        'registration_price',
        'renewal_price',
        'registrar',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
