<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class Member extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'rank',
        'company_id',
        'tenure',
        'photo_path',
        'registration_fee_paid',
    ];

    protected $casts = [
        'registration_fee_paid' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Activities this member is participating in.
     */
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_member')
            ->withPivot('fee_paid', 'payment_date', 'eligible', 'eligibility_notes', 'registered_by')
            ->withTimestamps();
    }
}
