<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'acronym',
        'category',
        'description',
        'established_date',
        'status',
        'logo_path',
        'email',
        'phone',
        'website',
        'social_media',
        'address',
    ];

    protected $casts = [
        'established_date' => 'date',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function activeMembers(): HasMany
    {
        return $this->members()->where('status', 'active');
    }

    public function upcomingEvents(): HasMany
    {
        return $this->events()->where('status', 'upcoming')
            ->where('event_date', '>=', now());
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'himpunan' => 'Himpunan Mahasiswa',
            'ukm' => 'Unit Kegiatan Mahasiswa',
            'ormawa' => 'Organisasi Kemahasiswaan',
            'bem' => 'Badan Eksekutif Mahasiswa',
            'osis' => 'Organisasi Siswa Intra Sekolah',
            default => $this->category,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            default => $this->status,
        };
    }
}
