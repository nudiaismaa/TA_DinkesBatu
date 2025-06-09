<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Posyandu extends Model
{
    use HasFactory, HasUuids, HasRoles, Notifiable;

    protected $table = 'posyandus';

    protected $guarded = ['id'];

    public function puskesmas() {
        return $this->belongsTo(Puskesmas::class, 'puskesmas_id', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_posyandu');
    }

    public function anak()
    {
        return $this->hasMany(Anak::class);
    }

    public function jadwal_posyandu(){
        return $this->hasMany(JadwalPosyandu::class);
    }

     public function riwayat()
    {
        return $this->hasMany(RiwayatPosyanduAnak::class, 'id', 'posyandu_id');
    }
}
