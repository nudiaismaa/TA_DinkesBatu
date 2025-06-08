<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Puskesmas extends Model
{
    use HasFactory, HasUuids, HasRoles, Notifiable;

    protected $table = 'puskesmas';

    protected $guarded = [
        'id',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    public function posyandu ()
    {
        return $this->hasMany(Posyandu::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_puskesmas');
    }
}
