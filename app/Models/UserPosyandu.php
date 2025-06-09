<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPosyandu extends Model
{
    use HasFactory;

    protected $table = 'user_posyandu';

    protected $guarded = ['id'];
}
