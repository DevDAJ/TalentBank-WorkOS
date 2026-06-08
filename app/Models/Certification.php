<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $fillable = [
        'user_id', 'name', 'issuing_organization',
        'issue_date', 'expiration_date', 'credential_url',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'expiration_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
