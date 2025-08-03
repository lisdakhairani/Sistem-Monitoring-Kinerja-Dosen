<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function datadiri(): HasMany
    {
        return $this->hasMany(Datadiri::class);
    }

    public function usulanJudul()
{
    return $this->hasMany(UsulanJudul::class);
}

public function seminarProposal()
{
    return $this->hasMany(SeminarProposal::class);
}

public function sidangTesis()
{
    return $this->hasMany(SeminarProposal::class);
}

public function konfirmasi()
{
    return $this->hasOne(Konfirmasi::class);
}

public function penelitian()
{
    return $this->hasOne(Penelitian::class);
}
public function pengabdian()
{
    return $this->hasOne(Pengabdian::class);
}

public function pengajaran()
{
    return $this->hasOne(Pengajaran::class);
}

public function penunjang()
{
    return $this->hasOne(Penunjang::class);
}
// dst

}
