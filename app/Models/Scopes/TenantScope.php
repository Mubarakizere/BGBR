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

            if ($user->hasRole('Domination Admin') && $user->domination_id) {
                if (in_array('domination_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'domination_id')) {
                    $builder->where($model->getTable() . '.domination_id', $user->domination_id);
                }
            } elseif ($user->hasRole('Battalion Commander') && $user->battalion_id) {
                if (in_array('battalion_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'battalion_id')) {
                    $builder->where($model->getTable() . '.battalion_id', $user->battalion_id);
                }
            } elseif (($user->hasRole('Company Captain') || $user->hasRole('Company Officer')) && $user->company_id) {
                if (in_array('company_id', $model->getFillable()) || \Schema::hasColumn($model->getTable(), 'company_id')) {
                    $builder->where($model->getTable() . '.company_id', $user->company_id);
                }
            }
        }
    }
}
