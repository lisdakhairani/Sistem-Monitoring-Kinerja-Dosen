<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsulanJudul extends Model
{
    protected $table = 'usulan_judul';

    protected $fillable = [
        'user_id',
        'id',
        'nama',
        'nim',
        'no_hp',
        'konsentrasi',
        'proposal_tesis',
        'jurnal_internasional',
        'jurnal_nasional',
        'tanggal_submit'
                // tambahkan kolom lain sesuai tabel
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
