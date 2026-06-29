<?php

namespace App\Policies;

use App\Models\User;

class GuestbookPolicy extends BaseContentPolicy
{
    public function approve(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'moderator']);
    }
}
