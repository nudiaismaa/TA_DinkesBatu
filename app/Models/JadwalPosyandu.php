<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class JadwalPosyandu extends Model
{
    use HasFactory, HasUuids, HasRoles, Notifiable;

    protected $table = 'jadwal_posyandus';

    protected $guarded = ['id'];

    public function posyandu(){
        return $this->belongsTo(Posyandu::class, 'posyandu_id', 'id');
    }
}
