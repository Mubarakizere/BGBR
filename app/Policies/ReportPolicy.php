<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use App\Models\Company;
use App\Models\Battalion;

class ReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only roles with explicit reporting duties can access reports
        return $user->hasRole('Super Admin')
            || $user->hasRole('Domination Admin')
            || $user->hasRole('Battalion Commander')
            || $user->hasRole('Company Captain')
            || $user->hasRole('Company Officer');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Report $report): bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        if ($user->hasRole('Domination Admin')) {
            // Domination Admins can view everything except other dominations if scoped (though here dominations can view all)
            return true;
        }

        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            if ($report->level === 'battalion') {
                return $report->entity_id === $user->battalion_id;
            }
            if ($report->level === 'company') {
                $company = Company::find($report->entity_id);
                return $company && $company->battalion_id === $user->battalion_id;
            }
        }

        if (($user->hasRole('Company Captain') || $user->hasRole('Company Officer')) && $user->company_id) {
            return $report->level === 'company' && $report->entity_id === $user->company_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update (submit/approve/reject) the model.
     */
    public function update(User $user, Report $report): bool
    {
        return $this->view($user, $report);
    }

    /**
     * Determine whether the user can submit the report.
     */
    public function submit(User $user, Report $report): bool
    {
        // Only drafts can be submitted
        if ($report->status !== 'draft') {
            return false;
        }

        // Only the company captain or battalion commander can submit their respective reports
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        if ($user->hasRole('Company Captain') && $user->company_id) {
            return $report->level === 'company' && $report->entity_id === $user->company_id;
        }

        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            return $report->level === 'battalion' && $report->entity_id === $user->battalion_id;
        }

        return false;
    }

    /**
     * Determine whether the user can approve/reject the report.
     */
    public function review(User $user, Report $report): bool
    {
        // Can only review submitted reports
        if ($report->status !== 'submitted') {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Domination Admin can approve/reject battalion reports
        if ($user->hasRole('Domination Admin') && $user->domination_id) {
            if ($report->level === 'battalion') {
                $battalion = Battalion::find($report->entity_id);
                return $battalion && $battalion->domination_id === $user->domination_id;
            }
        }

        // Battalion Commander can approve/reject company reports in their battalion
        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            if ($report->level === 'company') {
                $company = Company::find($report->entity_id);
                return $company && $company->battalion_id === $user->battalion_id;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): bool
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Only drafts or rejected reports can be deleted by their creators/owners
        if (!in_array($report->status, ['draft', 'rejected'])) {
            return false;
        }

        if ($user->hasRole('Company Captain') && $user->company_id) {
            return $report->level === 'company' && $report->entity_id === $user->company_id;
        }

        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            return $report->level === 'battalion' && $report->entity_id === $user->battalion_id;
        }

        return false;
    }
}
