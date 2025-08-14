<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
    use HasFactory;

    protected $table = 'pangkat';
    protected $primaryKey = 'id_pangkat';
    public $incrementing = true;

    protected $fillable = [
        'nama_pangkat',
        'golongan'
    ];
}
