<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class Battalion extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function domination()
    {
        return $this->belongsTo(Domination::class);
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
}
