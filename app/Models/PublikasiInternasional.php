<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublikasiInternasional extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $with = ['author', 'category'];

    public function category()
    {
        return $this->belongsTo(CategoriInternasional::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
