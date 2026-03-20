<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\RoleChecks;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles, RoleChecks;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Update the is_admin accessor to use roles
    public function getIsAdminAttribute()
    {
        return $this->hasRole(['super-admin', 'admin']);
    }

    // Update last login info
    public function updateLastLogin()
    {
        $this->last_login_at = now();
        $this->last_login_ip = request()->ip();
        $this->save();
    }

    // Scope to get active users
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope to get users by role
    public function scopeByRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class);
    }

    public function isCandidate()
    {
        return $this->hasRole('candidate');
    }
}