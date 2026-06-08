<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerSuggestion extends Model
{
    protected $fillable = [
        'user_id', 'suggested_role', 'description', 'match_score',
        'progression_path', 'skill_coverage', 'skill_gaps',
    ];

    protected function casts(): array
    {
        return [
            'progression_path' => 'array',
            'skill_coverage' => 'array',
            'skill_gaps' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
