<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarAntropometriPerempuan extends Model
{
    use HasFactory;
    
    protected $table = 'standar_antropometri_perempuan';
    public $timestamps = false;
}