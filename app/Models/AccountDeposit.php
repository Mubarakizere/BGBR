<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Scopes\TenantScope;

class AccountDeposit extends Model
{
    use HasUuids;

    protected $guarded = [];

    // Polymorphic-like but simple based on level and entity_id
    public function getEntityAttribute()
    {
        if ($this->level === 'battalion') {
            return Battalion::find($this->entity_id);
        }
        return null; // National deposit, entity might be empty or specific to something else
    }
}
