<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class Report extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
        'level',
        'entity_id',
        'type',
        'content',
        'file_path',
        'status',
        'submitted_by',
        'approved_by',
        'reviewer_notes',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getEntityAttribute()
    {
        if ($this->level === 'company') {
            return Company::find($this->entity_id);
        } elseif ($this->level === 'battalion') {
            return Battalion::find($this->entity_id);
        }
        return null;
    }
}
