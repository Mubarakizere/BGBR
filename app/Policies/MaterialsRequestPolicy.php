<?php

namespace App\Policies;

use App\Models\MaterialsRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaterialsRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Domination Admin') || $user->hasRole('Battalion Commander') || $user->hasRole('Company Captain');
    }

    public function view(User $user, MaterialsRequest $materialsRequest): bool
    {
        if ($user->hasRole('Super Admin')) return true;
        if ($user->hasRole('Domination Admin') && $user->domination_id === $materialsRequest->company->battalion->domination_id) return true;
        if ($user->hasRole('Battalion Commander') && $user->battalion_id === $materialsRequest->company->battalion_id) return true;
        if ($user->hasRole('Company Captain') && $user->company_id === $materialsRequest->company_id) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Company Captain');
    }

    public function update(User $user, MaterialsRequest $materialsRequest): bool
    {
        return $user->hasRole('Super Admin') || $user->hasRole('Battalion Commander');
    }

    public function delete(User $user, MaterialsRequest $materialsRequest): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function restore(User $user, MaterialsRequest $materialsRequest): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function forceDelete(User $user, MaterialsRequest $materialsRequest): bool
    {
        return $user->hasRole('Super Admin');
    }
}
