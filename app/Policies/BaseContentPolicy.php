<?php

namespace App\Policies;

use App\Models\User;

class BaseContentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['developer', 'admin']);
    }

    public function view(User $user, $model): bool
    {
        return $user->hasRole(['developer', 'admin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['developer', 'admin']);
    }

    public function update(User $user, $model): bool
    {
        return $user->hasRole(['developer', 'admin']);
    }

    public function delete(User $user, $model): bool
    {
        return $user->hasRole(['developer', 'admin']);
    }

    public function restore(User $user, $model): bool
    {
        return $user->hasRole(['developer', 'admin']);
    }

    public function forceDelete(User $user, $model): bool
    {
        return $user->isDeveloper();
    }
}
