<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KinerjaDosen extends Model
{
    use HasFactory;

    protected $table = 'kinerja_dosen';

    protected $fillable = [
        'id_dosen',
        'id_semester',
        'status_penilaian',
        'tanggal_pengisian',
        'tanggal_validasi',
        'id_validator',
        'total_skor',
        'catatan',
        'is_updated'
    ];

    protected $casts = [
        'tanggal_pengisian' => 'datetime:Y-m-d',
        'tanggal_validasi' => 'datetime:Y-m-d',
        'total_skor' => 'decimal:2',
        'is_updated' => 'boolean'
    ];

    protected $attributes = [
        'status_penilaian' => 'Belum Dinilai',
        'is_updated' => false
    ];

    // Status constants
    public const STATUS_BELUM_DINILAI = 'Belum Dinilai';
    public const STATUS_SEDANG_DINILAI = 'Sedang Dinilai';
    public const STATUS_SELESAI = 'Selesai';

    /**
     * Relationship with dosen (user)
     */
    public function dosen()
    {
        return $this->belongsTo(User::class, 'id_dosen')->withDefault([
            'name' => 'Dosen Tidak Ditemukan'
        ]);
    }

    /**
     * Relationship with validator (user)
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'id_validator')->withDefault([
            'name' => 'Belum Divalidasi'
        ]);
    }

    /**
     * Relationship with semester
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester')->withDefault([
            'nama_semester' => 'Semester Tidak Ditemukan'
        ]);
    }

    /**
     * Relationship with pengajaran activities
     */
    public function pengajaran(): HasMany
    {
        return $this->hasMany(KinerjaPengajaran::class, 'kinerja_dosen_id');
    }

    /**
     * Relationship with penelitian activities
     */
    public function penelitian(): HasMany
    {
        return $this->hasMany(KinerjaPenelitian::class, 'kinerja_dosen_id');
    }

    /**
     * Relationship with pengabdian activities
     */
    public function pengabdian(): HasMany
    {
        return $this->hasMany(KinerjaPengabdian::class, 'kinerja_dosen_id');
    }

    /**
     * Relationship with penunjang activities
     */
    public function penunjang(): HasMany
    {
        return $this->hasMany(KinerjaPenunjang::class, 'kinerja_dosen_id');
    }

    /**
     * Calculate total score based on weighted components
     */
    public function calculateTotalScore(): float
    {
        $avgPengajaran = $this->pengajaran->avg('skor') ?? 0;
        $avgPenelitian = $this->penelitian->avg('skor') ?? 0;
        $avgPengabdian = $this->pengabdian->avg('skor') ?? 0;
        $avgPenunjang = $this->penunjang->avg('skor') ?? 0;

        return ($avgPengajaran * 0.2) +
               ($avgPenelitian * 0.4) +
               ($avgPengabdian * 0.2) +
               ($avgPenunjang * 0.2);
    }

    /**
     * Check if performance has been validated
     */
    public function isValidated(): bool
    {
        return $this->status_penilaian === self::STATUS_SELESAI && $this->tanggal_validasi !== null;
    }

    /**
     * Get performance status color for display
     */
    public function getStatusColor(): string
    {
        return match($this->status_penilaian) {
            self::STATUS_SELESAI => 'success',
            self::STATUS_SEDANG_DINILAI => 'warning',
            default => 'secondary',
        };
    }
}
