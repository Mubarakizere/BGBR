<?php

namespace App\Policies;

use App\Models\Zone;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ZonePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage denominations') || $user->hasRole('Super Admin') || $user->hasRole('Denomination Admin');
    }

    public function view(User $user, Zone $zone): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Denomination Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Denomination Admin');
    }

    public function update(User $user, Zone $zone): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Denomination Admin');
    }

    public function delete(User $user, Zone $zone): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, Zone $zone): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, Zone $zone): bool
    {
        return $user->hasRole('Super Admin');
    }
}
