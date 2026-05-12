<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class Domination extends Model
{
    use HasUuids;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }
}
