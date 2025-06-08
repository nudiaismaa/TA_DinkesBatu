<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';

    /**
     * Get the kelurahans for the kecamatan.
     */
    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function puskesmas()
    {
        return $this->hasMany(Puskesmas::class);
    }

    /**
     * Get the kabupaten that owns the kecamatan.
     */
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}
