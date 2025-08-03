<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    use HasFactory;

    protected $table = 'pengabdian';

    protected $fillable = [
        'user_id',
        'judul_kegiatan',
        'jenis_kegiatan',
        'peran',
        'lokasi',
        'tahun_kegiatan',
        'sumber_dana',
        'jumlah_dana',
        'output',
        'file_bukti',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
