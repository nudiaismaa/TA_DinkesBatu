<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'anak';

    protected $guarded = [
        'id',
    ];

    public function orangtua()
    {
        return $this->belongsTo(OrangTua::class, 'orangtua_id', 'id');
    }

    public function kelurahan()
    {
        return $this->hasOne(Kelurahan::class, 'id', 'kelurahan_id',);
    }

    public function posyandu()
    {
        return $this->hasOne(Posyandu::class, 'id', 'posyandu_id');
    }

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function userStatus()
    {
        return $this->hasOne(UserStatus::class, 'id', 'user_status_id');
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatPosyanduAnak::class, 'anak_id', 'id');
    }

    public function isActive(): bool
    {
        return $this->user_status_id === 3;
    }
}
