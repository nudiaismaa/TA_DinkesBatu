<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class JenisImunisasi extends Model
{
    use HasFactory, Notifiable, HasRoles, HasUuids;

    protected $table = 'jenis_imunisasis';

    protected $guarded = ['id'];

    public function imunisasi()
    {
        return  $this->belongsToMany(Imunisasi::class, 'imunisasi_jenis_imunisasi');
    }
}
