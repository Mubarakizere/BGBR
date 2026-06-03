<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteGalleryImage extends Model
{
    protected $fillable = [
        'title',
        'caption',
        'image_path',
        'album',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeAlbum($query, string $album)
    {
        return $query->where('album', $album);
    }
}
