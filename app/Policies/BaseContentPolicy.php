<?php

namespace App\Policies;

use App\Models\User;

class BaseContentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'moderator']);
    }

    public function view(User $user, $model): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'moderator']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'moderator']);
    }

    public function update(User $user, $model): bool
    {
        return $user->hasRole(['super_admin', 'admin', 'moderator']);
    }

    public function delete(User $user, $model): bool
    {
        return $user->hasRole(['super_admin', 'admin']);
    }

    public function restore(User $user, $model): bool
    {
        return $user->hasRole(['super_admin', 'admin']);
    }

    public function forceDelete(User $user, $model): bool
    {
        return $user->isSuperAdmin();
    }
}
