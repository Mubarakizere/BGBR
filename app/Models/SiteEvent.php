<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'event_date',
        'end_date',
        'image_path',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
