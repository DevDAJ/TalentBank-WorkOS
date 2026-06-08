<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkExperience;

class WorkExperiencePolicy
{
    public function view(User $user, WorkExperience $workExperience): bool
    {
        return $workExperience->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, WorkExperience $workExperience): bool
    {
        return $workExperience->user_id === $user->id;
    }

    public function delete(User $user, WorkExperience $workExperience): bool
    {
        return $workExperience->user_id === $user->id;
    }
}
