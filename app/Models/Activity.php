<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Activity extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'description',
        'participation_fee',
        'requirements',
        'date',
        'status',
        'location',
    ];

    protected $casts = [
        'participation_fee' => 'decimal:2',
        'date' => 'date',
    ];

    /**
     * No TenantScope — activities are national/global (created by Super Admin).
     */

    /**
     * Members participating in this activity.
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'activity_member')
            ->withPivot('fee_paid', 'payment_date', 'eligible', 'eligibility_notes', 'registered_by')
            ->withTimestamps();
    }

    /**
     * Members who have paid the participation fee.
     */
    public function paidParticipants()
    {
        return $this->members()->wherePivot('fee_paid', true);
    }

    /**
     * Members who have NOT paid the participation fee.
     */
    public function unpaidParticipants()
    {
        return $this->members()->wherePivot('fee_paid', false);
    }

    /**
     * Total expected fees from all participants.
     */
    public function getTotalExpectedFeesAttribute(): float
    {
        return $this->members()->count() * (float) $this->participation_fee;
    }

    /**
     * Total collected fees from paid participants.
     */
    public function getTotalCollectedFeesAttribute(): float
    {
        return $this->paidParticipants()->count() * (float) $this->participation_fee;
    }
}
