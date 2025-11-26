<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'email_preferences' => 'array',
            'taxexempt' => 'boolean',
            'latefeeoveride' => 'boolean',
            'overideduenotices' => 'boolean',
            'separateinvoices' => 'boolean',
            'disableautocc' => 'boolean',
            'emailoptout' => 'boolean',
            'marketing_emails_opt_in' => 'boolean',
            'overrideautoclose' => 'boolean',
            'email_verified' => 'boolean',
            'allowSingleSignOn' => 'boolean',
            'credit' => 'decimal:2',
        ];
    }

    protected $fillable = [
        'uuid',
        'owner_user_id',
        'firstname',
        'lastname',
        'companyname',
        'email',
        'address1',
        'address2',
        'city',
        'state',
        'postcode',
        'countrycode',
        'phonenumber',
        'tax_id',
        'email_preferences',
        'currency_id',
        'defaultgateway',
        'groupid',
        'status',
        'source',
        'credit',
        'taxexempt',
        'latefeeoveride',
        'overideduenotices',
        'separateinvoices',
        'disableautocc',
        'emailoptout',
        'marketing_emails_opt_in',
        'overrideautoclose',
        'allowSingleSignOn',
        'email_verified',
        'language',
        'lastlogin',
        'notes',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Client $client) {
            if (empty($client->uuid)) {
                $client->uuid = Str::uuid();
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(ClientUser::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function customFields(): HasMany
    {
        return $this->hasMany(ClientCustomField::class);
    }

    public function getFullnameAttribute(): string
    {
        return trim("{$this->firstname} {$this->lastname}");
    }

    public function getIsOptedInToMarketingEmailsAttribute(): bool
    {
        return (bool) $this->marketing_emails_opt_in;
    }

    public function getStats(): array
    {
        $invoices = $this->invoices;

        return [
            'numdueinvoices' => $invoices->where('status', 'Unpaid')->count(),
            'dueinvoicesbalance' => $invoices->where('status', 'Unpaid')->sum('total'),
            'incredit' => $this->credit > 0,
            'creditbalance' => $this->credit,
            'numoverdueinvoices' => $invoices->where('status', 'Unpaid')->where('duedate', '<', now())->count(),
            'overdueinvoicesbalance' => $invoices->where('status', 'Unpaid')->where('duedate', '<', now())->sum('total'),
            'numunpaidinvoices' => $invoices->where('status', 'Unpaid')->count(),
            'unpaidinvoicesamount' => $invoices->where('status', 'Unpaid')->sum('total'),
            'numpaidinvoices' => $invoices->where('status', 'Paid')->count(),
            'paidinvoicesamount' => $invoices->where('status', 'Paid')->sum('total'),
            'productsnumactive' => $this->products()->where('status', 'Active')->count(),
            'productsnumtotal' => $this->products()->count(),
            'numactivedomains' => $this->domains()->where('status', 'Active')->count(),
            'numdomains' => $this->domains()->count(),
            'numquotes' => $this->quotes()->count(),
            'numtickets' => $this->tickets()->count(),
            'numactivetickets' => $this->tickets()->where('status', 'Open')->count(),
        ];
    }
}
