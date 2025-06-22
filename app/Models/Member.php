<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'student_id',
        'name',
        'email',
        'phone',
        'position',
        'join_date',
        'status',
        'photo_path',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'alumni' => 'Alumni',
            default => $this->status,
        };
    }
}
