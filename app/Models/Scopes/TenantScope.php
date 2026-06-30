<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->hasUser()) {
            $user = auth()->user();

            if ($user->hasRole('Super Admin')) {
                // No filters for Super Admin
                return;
            }

            if ($user->hasRole('Denomination Admin') && $user->denomination_id) {
                if (in_array('denomination_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'denomination_id')) {
                    $builder->where($model->getTable() . '.denomination_id', $user->denomination_id);
                } elseif (in_array('battalion_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'battalion_id')) {
                    $builder->whereHas('battalion', function ($query) use ($user) {
                        $query->where('denomination_id', $user->denomination_id);
                    });
                } elseif (in_array('company_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'company_id')) {
                    $builder->whereHas('company.battalion', function ($query) use ($user) {
                        $query->where('denomination_id', $user->denomination_id);
                    });
                }
            } elseif ($user->hasRole('Battalion Commander') && $user->battalion_id) {
                if (in_array('battalion_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'battalion_id')) {
                    $builder->where($model->getTable() . '.battalion_id', $user->battalion_id);
                } elseif (in_array('company_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'company_id')) {
                    $builder->whereHas('company', function ($query) use ($user) {
                        $query->where('battalion_id', $user->battalion_id);
                    });
                }
            } elseif ($user->hasRole('Company Captain') || $user->hasRole('Company Officer')) {
                // Determine which companies the user manages
                $companyIds = $user->officeredCompanies()->pluck('companies.id')->toArray();
                if ($user->company_id && !in_array($user->company_id, $companyIds)) {
                    $companyIds[] = $user->company_id;
                }

                if (!empty($companyIds)) {
                    if (in_array('company_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'company_id')) {
                        $builder->whereIn($model->getTable() . '.company_id', $companyIds);
                    }
                } else {
                    $builder->whereRaw('1 = 0');
                }
            } else {
                // If user is just a regular user, they should ideally only see data for their company.
                if ($user->company_id) {
                    if (in_array('company_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'company_id')) {
                        $builder->where($model->getTable() . '.company_id', $user->company_id);
                    }
                } else {
                    // For safety, if they are completely unassigned and not an admin, they see nothing of tenant-scoped models.
                    // This prevents unassigned users from seeing the whole system.
                    $builder->whereRaw('1 = 0');
                }
            }
        }
    }
}
