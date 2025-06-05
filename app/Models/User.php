<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $table = 'users';

    protected $guarded = [
        'id',
    ];

    public function userStatus()
    {
        return $this->hasOne(UserStatus::class, 'id', 'user_status_id');
    }

    public function isActive(): bool
    {
        return $this->user_status_id === 3;
    }

    public function orangtua()
    {
        return $this->hasOne(OrangTua::class, 'user_id');
    }

    public function puskesmas()
    {
        return $this->belongsToMany(Puskesmas::class, 'user_puskesmas');
    }

    public function posyandu()
    {
        return $this->belongsToMany(Posyandu::class, 'user_posyandu');
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
