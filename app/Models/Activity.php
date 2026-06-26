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
        'target_audience',
        'entity_id',   // kept for legacy compatibility
        'entity_ids',  // new: JSON array of target entity UUIDs
    ];

    protected $casts = [
        'participation_fee' => 'decimal:2',
        'date'             => 'date',
        'entity_ids'       => 'array',
    ];

    /**
     * No TenantScope — visibility is handled by target_audience scoping in the controller.
     */

    /**
     * Get the entity this activity targets.
     */
    /**
     * Returns the primary (first) entity for backward-compat display.
     */
    public function getEntityAttribute()
    {
        $ids = $this->entity_ids ?? ($this->entity_id ? [$this->entity_id] : []);
        $first = $ids[0] ?? null;

        return match ($this->target_audience) {
            'denomination' => $first ? Denomination::find($first) : null,
            'battalion'  => $first ? Battalion::find($first)  : null,
            'company'    => $first ? Company::find($first)    : null,
            default      => null,
        };
    }

    /**
     * Returns ALL targeted entities as a collection.
     */
    public function getEntitiesAttribute()
    {
        $ids = $this->entity_ids ?? ($this->entity_id ? [$this->entity_id] : []);
        if (empty($ids)) {
            return collect();
        }

        return match ($this->target_audience) {
            'denomination' => Denomination::whereIn('id', $ids)->get(),
            'battalion'  => Battalion::whereIn('id', $ids)->get(),
            'company'    => Company::whereIn('id', $ids)->get(),
            default      => collect(),
        };
    }

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
