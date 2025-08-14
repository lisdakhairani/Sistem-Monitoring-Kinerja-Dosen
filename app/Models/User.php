<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tempat_lahir',
        'tanggal_lahir',
        'nip',
        'nidn',
        'jabatan',
        'pangkat',
        'photos',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date',
        'is_admin' => 'boolean'
    ];

    public function updateProfilePhoto($photo)
    {
        // Hapus foto lama jika ada
        if ($this->photos) {
            Storage::delete('avatars/'.$this->photos);
        }

        // Buat folder jika belum ada
        if (!Storage::exists('avatars')) {
            Storage::makeDirectory('avatars');
        }

        // Generate nama file random
        $extension = $photo->getClientOriginalExtension();
        $filename = 'Avatar-' . bin2hex(random_bytes(8)) . '.' . $extension;

        // Simpan file
        $photo->storeAs('avatars', $filename);

        // Simpan nama file ke database
        $this->photos = $filename;
        $this->save();

        return $filename;
    }
}
