<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Announcement extends Model
{
    use HasUuids, LogsActivity;

    protected $fillable = [
        'title',
        'content',
        'visibility_level',
        'entity_id',   // kept for legacy compatibility
        'entity_ids',  // new: JSON array of target entity UUIDs
        'created_by',
    ];

    protected $casts = [
        'entity_ids' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Announcement was {$eventName}");
    }

    /**
     * The user who created this announcement.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the primary (first) entity this announcement targets.
     */
    public function getEntityAttribute()
    {
        $ids = $this->entity_ids ?? ($this->entity_id ? [$this->entity_id] : []);
        $first = $ids[0] ?? null;

        return match ($this->visibility_level) {
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

        return match ($this->visibility_level) {
            'denomination' => Denomination::whereIn('id', $ids)->get(),
            'battalion'  => Battalion::whereIn('id', $ids)->get(),
            'company'    => Company::whereIn('id', $ids)->get(),
            default      => collect(),
        };
    }
}
