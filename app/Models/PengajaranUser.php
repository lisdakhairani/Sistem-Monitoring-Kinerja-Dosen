<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajaranUser extends Model
{
    use HasFactory;

    protected $table = 'pengajaran_user'; // nama tabel di database kamu

    protected $fillable = [
        'user_id',
        'nama_mata_kuliah',
        'kode_mata_kuliah',
        'jumlah_sks',
        'semester',
        'tahun_ajaran',
        'jumlah_pertemuan',
        'file_bukti',
        'nilai'
    ];
}
