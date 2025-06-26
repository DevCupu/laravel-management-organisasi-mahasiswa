<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'content',
        'type',
        'status',
        'publish_date',
        'expire_date',
        'created_by',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'expire_date' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'published' => 'Dipublikasi',
            'archived' => 'Diarsipkan',
            default => $this->status,
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'general' => 'Umum',
            'urgent' => 'Penting',
            'event' => 'Kegiatan',
            'academic' => 'Akademik',
            default => $this->type,
        };
    }

    public function getIsActiveAttribute(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        if ($this->publish_date > now()) {
            return false;
        }

        if ($this->expire_date && $this->expire_date < now()) {
            return false;
        }

        return true;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expire_date && $this->expire_date < now();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'published')
            ->where('publish_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('expire_date')
                    ->orWhere('expire_date', '>=', now());
            });
    }

    public function scopeByOrganization($query, $organizationId)
    {
        if ($organizationId === 'global') {
            return $query->whereNull('organization_id');
        }

        return $query->where('organization_id', $organizationId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
