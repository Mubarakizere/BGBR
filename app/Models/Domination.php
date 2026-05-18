<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Domination extends Model
{
    use HasUuids, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logUnguarded()->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Domination was {$eventName}");
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function battalions()
    {
        return $this->hasMany(Battalion::class);
    }

    public function getContributionPercentageAttribute(): float
    {
        $totalMembers = 0;
        $paidMembers = 0;

        foreach ($this->battalions as $battalion) {
            foreach ($battalion->companies as $company) {
                $totalMembers += $company->members()->count();
                $paidMembers += $company->members()->where('registration_fee_paid', true)->count();
            }
        }

        if ($totalMembers === 0) return 0;
        return round(($paidMembers / $totalMembers) * 100, 2);
    }
}
