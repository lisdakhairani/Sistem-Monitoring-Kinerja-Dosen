<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    use HasFactory;

    protected $table = 'pengajaran';

    protected $fillable = [
        'user_id',
        'nama_mata_kuliah',
        'kode_mata_kuliah',
        'jumlah_sks',
        'semester',
        'tahun_ajaran',
        'jumlah_pertemuan',
        'file_bukti',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
