<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;

    protected $table = 'penelitian';

    protected $fillable = [
        'user_id',
        'judul_penelitian',
        'jenis_penelitian',
        'peran',
        'sumber_dana',
        'jumlah_dana',
        'tahun_kegiatan',
        'status',
        'output',
        'file_bukti',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
