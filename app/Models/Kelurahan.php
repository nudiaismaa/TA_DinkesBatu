<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahans';

    /**
     * Get the posyandus for the kelurahan.
     */
    public function posyandu()
    {
        return $this->hasMany(Posyandu::class);
    }

    public function orangtua()
    {
        return $this->hasMany(OrangTua::class);
    }

    public function anak()
    {
        return $this->hasMany(Anak::class);
    }

    /**
     * Get the kecamatan that owns the kelurahan.
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
