<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'category',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'max_participants',
        'current_participants',
        'status',
        'registration_deadline',
        'poster_path',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'registration_deadline' => 'date',
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
            'upcoming' => 'Akan Datang',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getAvailableSlotsAttribute(): int
    {
        return $this->max_participants ? $this->max_participants - $this->current_participants : 0;
    }

    public function isRegistrationOpenAttribute(): bool
    {
        if ($this->registration_deadline && $this->registration_deadline < now()) {
            return false;
        }

        if ($this->max_participants && $this->current_participants >= $this->max_participants) {
            return false;
        }

        return $this->status === 'upcoming';
    }
}
