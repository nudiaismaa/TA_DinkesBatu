<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Imunisasi extends Model
{
    use HasFactory, HasUuids, HasRoles, Notifiable;

    protected $table = 'imunisasis';

    protected $guarded = ['id'];

    public function jenis_imunisasi()
    {
        return $this->belongsToMany(JenisImunisasi::class, 'imunisasi_jenis_imunisasi');
    }

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'pemeriksaan_id', 'id');
    }
}
