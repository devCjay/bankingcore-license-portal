<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseVerification extends Model
{
    protected $fillable = [
        'license_id',
        'license_key',
        'domain',
        'email',
        'ip_address',
        'status',
        'message',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }
}
