<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user_statuses';

    protected $guarded = [
        'id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_status_id');
    }

    public function anak()
    {
        return $this->belongsTo(Anak::class, 'user_status_id');
    }
}
