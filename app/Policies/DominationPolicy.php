<?php

namespace App\Policies;

use App\Models\Domination;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DominationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage dominations') || $user->hasRole('Super Admin');
    }

    public function view(User $user, Domination $domination): bool
    {
        if ($user->hasRole('Super Admin')) return true;
        if ($user->hasRole('Domination Admin') && $user->domination_id === $domination->id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function update(User $user, Domination $domination): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function delete(User $user, Domination $domination): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, Domination $domination): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, Domination $domination): bool
    {
        return $user->hasRole('Super Admin');
    }
}
