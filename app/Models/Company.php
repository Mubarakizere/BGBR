<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class Company extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function battalion()
    {
        return $this->belongsTo(Battalion::class);
    }

    public function officers()
    {
        return $this->belongsToMany(User::class, 'company_officer')->withPivot('rank')->withTimestamps();
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function getContributionPercentageAttribute(): float
    {
        $total = $this->members()->count();
        if ($total === 0) return 0;
        
        $paid = $this->members()->where('registration_fee_paid', true)->count();
        return round(($paid / $total) * 100, 2);
    }
}
