<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_approved',
        'denomination_id',
        'battalion_id',
        'company_id',
        'photo_path',
        'fee_valid_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fee_valid_until' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'is_approved', 'denomination_id', 'battalion_id', 'company_id', 'photo_path'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "User was {$eventName}");
    }

    public function denomination(): BelongsTo
    {
        return $this->belongsTo(Denomination::class);
    }

    public function battalion(): BelongsTo
    {
        return $this->belongsTo(Battalion::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function officeredCompanies()
    {
        return $this->belongsToMany(Company::class, 'company_officer')->withPivot('rank')->withTimestamps();
    }

    public function registrationFees()
    {
        return $this->hasMany(RegistrationFee::class);
    }
}
