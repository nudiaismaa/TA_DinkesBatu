<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupatens';

    /**
     * Get the kecamatans for the kabupaten.
     */
    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }

    /**
     * Get the provinsi that owns the kabupaten.
     */
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
}
