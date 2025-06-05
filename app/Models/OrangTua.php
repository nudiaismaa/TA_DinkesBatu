<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class OrangTua extends Model
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = 'orangtua';

    protected $guarded = [
        'id',
    ];

    public function kelurahan() {
        return $this->hasOne(Kelurahan::class, 'id', 'kelurahan_id',);
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function anak() {
        return $this->hasMany(Anak::class, 'orangtua_id', 'id');
    }
}
