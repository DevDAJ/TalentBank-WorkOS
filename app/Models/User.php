<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'location', 'title', 'summary', 'website', 'linkedin_url', 'github_url'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function education(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function careerSuggestions(): HasMany
    {
        return $this->hasMany(CareerSuggestion::class);
    }
}
