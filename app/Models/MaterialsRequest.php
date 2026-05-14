<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class MaterialsRequest extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
