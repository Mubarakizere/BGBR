<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use App\Models\Battalion;
use App\Models\Company;

class AnnouncementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Announcement $announcement): bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // If it's not approved, only the creator or someone with approval permission can view it
        if (!$announcement->is_approved) {
            if ($announcement->created_by !== $user->id && !$user->can('approve announcements')) {
                return false;
            }
        }

        $level = $announcement->visibility_level;
        $entityId = $announcement->entity_id;

        if ($level === 'national') {
            return true;
        }

        if ($user->hasRole('Denomination Admin') && $user->denomination_id) {
            if ($level === 'denomination') {
                return $entityId === $user->denomination_id;
            }
            if ($level === 'battalion') {
                $battalion = Battalion::find($entityId);
                return $battalion && $battalion->denomination_id === $user->denomination_id;
            }
        }

        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            $battalion = Battalion::find($user->battalion_id);
            $denominationId = $battalion?->denomination_id;

            if ($level === 'denomination') {
                return $entityId === $denominationId;
            }
            if ($level === 'battalion') {
                return $entityId === $user->battalion_id;
            }
            if ($level === 'company') {
                $company = Company::find($entityId);
                return $company && $company->battalion_id === $user->battalion_id;
            }
        }

        if (($user->hasRole('Company Captain') || $user->hasRole('Company Officer') || $user->hasRole('Member')) && $user->company_id) {
            $company = Company::find($user->company_id);
            $battalion = $company?->battalion;
            $denominationId = $battalion?->denomination_id;

            if ($level === 'denomination') {
                return $entityId === $denominationId;
            }
            if ($level === 'battalion') {
                return $entityId === $company?->battalion_id;
            }
            if ($level === 'company') {
                return $entityId === $user->company_id;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin')
            || $user->hasRole('Denomination Admin')
            || $user->hasRole('Battalion Commander')
            || $user->hasRole('Company Captain');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Announcement $announcement): bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return $announcement->created_by === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Announcement $announcement): bool
    {
        return $this->update($user, $announcement);
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(User $user, Announcement $announcement): bool
    {
        return $user->can('approve announcements');
    }
}
