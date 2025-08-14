<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaPenunjang extends Model
{
    use HasFactory;

    protected $table = 'kinerja_penunjang';

    protected $fillable = [
        'kinerja_dosen_id',
        'jenis_kegiatan',
        'nama_kegiatan',
        'tingkat_kegiatan',
        'tanggal_kegiatan',
        'institusi_penyelenggara',
        'bukti_path',
        'skor'
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date'
    ];

    public function kinerjaDosen()
    {
        return $this->belongsTo(KinerjaDosen::class);
    }
}
