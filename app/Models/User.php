<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'organization_id',
        'student_id',
        'phone',
        'last_login_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    // Role Methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizationAdmin(): bool
    {
        return $this->role === 'organization_admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    // Permission Methods
    public function canManageAllOrganizations(): bool
    {
        return $this->isAdmin();
    }

    public function canManageOrganization($organizationId): bool
    {
        if ($this->canManageAllOrganizations()) {
            return true;
        }
        
        return $this->isOrganizationAdmin() && $this->organization_id == $organizationId;
    }

    public function canViewOrganization($organizationId): bool
    {
        if ($this->canManageAllOrganizations()) {
            return true;
        }
        
        return $this->organization_id == $organizationId;
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeByOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    // Accessors
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Admin Sistem',
            'organization_admin' => 'Admin Organisasi',
            'member' => 'Anggota',
            default => $this->role,
        };
    }
}
