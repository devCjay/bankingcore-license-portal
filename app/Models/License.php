<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_key',
        'customer_name',
        'customer_email',
        'product_name',
        'domain',
        'allowed_domains',
        'status',
        'max_activations',
        'activation_count',
        'expires_at',
        'last_verified_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'allowed_domains' => 'array',
            'expires_at' => 'datetime',
            'last_verified_at' => 'datetime',
            'max_activations' => 'integer',
            'activation_count' => 'integer',
        ];
    }

    public static function generateKey(): string
    {
        return 'BANK-' . implode('-', str_split(Str::upper(Str::random(24)), 6));
    }

    public function domains(): array
    {
        $domains = $this->allowed_domains ?: [];

        if ($this->domain && !in_array($this->domain, $domains, true)) {
            array_unshift($domains, $this->domain);
        }

        return array_values(array_filter(array_unique($domains)));
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
