<?php

namespace App\Policies;

use App\Models\Denomination;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DenominationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage denominations') || $user->hasRole('Super Admin');
    }

    public function view(User $user, Denomination $denomination): bool
    {
        if ($user->hasRole('Super Admin')) return true;
        if ($user->hasRole('Denomination Admin') && $user->denomination_id === $denomination->id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function update(User $user, Denomination $denomination): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function delete(User $user, Denomination $denomination): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, Denomination $denomination): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, Denomination $denomination): bool
    {
        return $user->hasRole('Super Admin');
    }
}
