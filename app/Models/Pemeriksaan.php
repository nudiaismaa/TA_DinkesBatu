<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pemeriksaan';

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date', // atau 'datetime'
    ];

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'anak_id', 'id');
    }

    public function imunisasi()
    {
        return $this->hasOne(Imunisasi::class);
    }
}
