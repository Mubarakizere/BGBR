<?php

namespace App\Policies;

use App\Models\Battalion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BattalionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage battalions') || $user->hasRole('Super Admin') || $user->hasRole('Denomination Admin');
    }

    public function view(User $user, Battalion $battalion): bool
    {
        if ($user->hasRole('Super Admin')) return true;
        if ($user->hasRole('Denomination Admin') && $user->denomination_id === $battalion->denomination_id) return true;
        if ($user->hasRole('Battalion Commander') && $user->battalion_id === $battalion->id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Denomination Admin');
    }

    public function update(User $user, Battalion $battalion): bool
    {
        return $user->hasRole('Super Admin') || ($user->hasRole('Denomination Admin') && $user->denomination_id === $battalion->denomination_id);
    }

    public function delete(User $user, Battalion $battalion): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, Battalion $battalion): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, Battalion $battalion): bool
    {
        return $user->hasRole('Super Admin');
    }
}
