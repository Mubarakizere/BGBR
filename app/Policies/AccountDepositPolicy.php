<?php

namespace App\Policies;

use App\Models\AccountDeposit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountDepositPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Domination Admin');
    }

    public function view(User $user, AccountDeposit $accountDeposit): bool
    {
        if ($user->hasRole('Super Admin')) return true;
        if ($user->hasRole('Domination Admin') && $accountDeposit->level === 'battalion') {
            $battalion = \App\Models\Battalion::find($accountDeposit->entity_id);
            if ($battalion && $battalion->domination_id === $user->domination_id) return true;
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Domination Admin');
    }

    public function update(User $user, AccountDeposit $accountDeposit): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function delete(User $user, AccountDeposit $accountDeposit): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, AccountDeposit $accountDeposit): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, AccountDeposit $accountDeposit): bool
    {
        return $user->hasRole('Super Admin');
    }
}
