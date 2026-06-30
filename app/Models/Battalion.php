<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Battalion extends Model
{
    use HasUuids, LogsActivity;

    protected $guarded = [];
    protected $appends = ['is_active'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logUnguarded()->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Battalion was {$eventName}");
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function denomination()
    {
        return $this->belongsTo(Denomination::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function getContributionPercentageAttribute(): float
    {
        $totalMembers = 0;
        $paidMembers = 0;

        foreach ($this->companies as $company) {
            $totalMembers += $company->members()->count();
            $paidMembers += $company->members()->where('registration_fee_paid', true)->count();
        }

        if ($totalMembers === 0) return 0;
        return round(($paidMembers / $totalMembers) * 100, 2);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->companies()->count() >= 5;
    }
}
