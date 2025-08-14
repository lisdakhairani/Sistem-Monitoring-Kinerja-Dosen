<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaPenelitian extends Model
{
    use HasFactory;

    protected $table = 'kinerja_penelitian';

    protected $fillable = [
        'kinerja_dosen_id',
        'judul_penelitian',
        'jenis_penelitian',
        'peran_penelitian',
        'sumber_dana',
        'jumlah_dana',
        'tahun_penelitian',
        'status_penelitian',
        'output_luaran',
        'bukti_path',
        'bentuk_penelitian',
        'nomor_volume_isbn',
        'penerbit',
        'jumlah_halaman',
        'skor',
    ];

    public function kinerjaDosen()
    {
        return $this->belongsTo(KinerjaDosen::class);
    }
}
