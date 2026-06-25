<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Zone extends Model
{
    use HasUuids, LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logUnguarded()->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Zone was {$eventName}");
    }

    public function battalions()
    {
        return $this->hasMany(Battalion::class);
    }
}
