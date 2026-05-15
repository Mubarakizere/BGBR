<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    /**
     * All authenticated roles can view activities.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * All authenticated roles can view a single activity.
     */
    public function view(User $user, Activity $activity): bool
    {
        return true;
    }

    /**
     * Only Super Admin can create activities.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage activities');
    }

    /**
     * Only Super Admin can update activities.
     */
    public function update(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('manage activities');
    }

    /**
     * Only Super Admin can delete activities.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('manage activities');
    }

    /**
     * Company Captain and Company Officer can register participants from their company.
     */
    public function registerParticipant(User $user): bool
    {
        return $user->hasPermissionTo('submit activity participation');
    }

    /**
     * Company Captain and Company Officer can mark fee payments.
     */
    public function markPayment(User $user): bool
    {
        return $user->hasPermissionTo('submit activity participation');
    }

    public function restore(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('manage activities');
    }

    public function forceDelete(User $user, Activity $activity): bool
    {
        return $user->hasPermissionTo('manage activities');
    }
}
