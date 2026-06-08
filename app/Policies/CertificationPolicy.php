<?php

namespace App\Policies;

use App\Models\Certification;
use App\Models\User;

class CertificationPolicy
{
    public function view(User $user, Certification $certification): bool
    {
        return $certification->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Certification $certification): bool
    {
        return $certification->user_id === $user->id;
    }

    public function delete(User $user, Certification $certification): bool
    {
        return $certification->user_id === $user->id;
    }
}
