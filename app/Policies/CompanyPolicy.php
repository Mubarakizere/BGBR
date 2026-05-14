<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage companies') || $user->hasRole('Super Admin') || $user->hasRole('Domination Admin') || $user->hasRole('Battalion Commander');
    }

    public function view(User $user, Company $company): bool
    {
        if ($user->hasRole('Super Admin')) return true;
        if ($user->hasRole('Domination Admin') && $user->domination_id === $company->battalion->domination_id) return true;
        if ($user->hasRole('Battalion Commander') && $user->battalion_id === $company->battalion_id) return true;
        if (($user->hasRole('Company Captain') || $user->hasRole('Company Officer')) && $user->company_id === $company->id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Domination Admin') || $user->hasRole('Battalion Commander');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->hasRole('Super Admin') || ($user->hasRole('Battalion Commander') && $user->battalion_id === $company->battalion_id);
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $user->hasRole('Super Admin');
    }
}
