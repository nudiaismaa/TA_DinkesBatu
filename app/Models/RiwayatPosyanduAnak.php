<?php

namespace App\Models;

use App\Http\Controllers\PosyanduController;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class RiwayatPosyanduAnak extends Model
{
    use HasFactory, HasUuids, HasRoles, Notifiable;

    protected $table = 'riwayat_posyandu_anak';

    protected $guarded = [
        'id',
    ];

     public function anak()
    {
        return $this->belongsTo(Anak::class, 'anak_id', 'id');
    }

       public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'id');
    }
}
