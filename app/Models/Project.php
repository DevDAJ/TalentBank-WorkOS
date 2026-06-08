<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'technologies_used',
        'url', 'start_date', 'end_date',
    ];

    protected function casts(): array
    {
        return [
            'technologies_used' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
