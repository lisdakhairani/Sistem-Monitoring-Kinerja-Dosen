<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaPengajaran extends Model
{
    use HasFactory;

    protected $table = 'kinerja_pengajaran';

    protected $fillable = [
        'kinerja_dosen_id',
        'nama_matkul',
        'kode_matkul',
        'sks',
        'semester',
        'tahun_ajaran',
        'jumlah_pertemuan',
        'bukti_path',
        'jenis_pengajaran',
        'skor'
    ];

    public function kinerjaDosen()
    {
        return $this->belongsTo(KinerjaDosen::class);
    }
}