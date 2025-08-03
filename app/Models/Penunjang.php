<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penunjang extends Model
{
    use HasFactory;

    protected $table = 'penunjang';

    protected $fillable = [
        'user_id',
        'jenis_kegiatan',
        'nama_kegiatan',
        'tingkat_kegiatan',
        'tanggal_kegiatan',
        'institusi_penyelenggara',
        'file_bukti',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
