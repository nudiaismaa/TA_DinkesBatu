<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StandarAntropometriLaki extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'standar_antropometri_laki';

    protected $guarded = [
        'id',
    ];
}