<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_semester',
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];
}
