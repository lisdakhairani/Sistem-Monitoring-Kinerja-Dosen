<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanAkademik extends Model
{
    protected $table = 'jabatan_akademik'; // optional if following Laravel naming
    protected $fillable = ['nama_jabatan']; // match your migration

    // If you're using timestamps (default is true)
    public $timestamps = true;
}
