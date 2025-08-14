<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaPengabdian extends Model
{
    use HasFactory;

    protected $table = 'kinerja_pengabdian';

    protected $fillable = [
        'kinerja_dosen_id',
        'judul_kegiatan',
        'jenis_kegiatan',
        'peran_pengabdian',
        'lokasi',
        'tahun_kegiatan',
        'sumber_dana',
        'jumlah_dana',
        'output',
        'bukti_path',
        'tingkat_kegiatan',
        'skor',
        'bidang_keahlian'
    ];

    public function kinerjaDosen()
    {
        return $this->belongsTo(KinerjaDosen::class);
    }
}