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
        'entity_id',
        'created_by',
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
     * Get the entity this announcement targets.
     */
    public function getEntityAttribute()
    {
        return match ($this->visibility_level) {
            'domination' => Domination::find($this->entity_id),
            'battalion' => Battalion::find($this->entity_id),
            'company' => Company::find($this->entity_id),
            default => null, // 'national' has no specific entity
        };
    }
}
