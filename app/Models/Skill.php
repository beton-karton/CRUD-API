<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';
    protected $fillable = [
        'pokemon_id',
        'name_eng',
        'name_rus',
        'image'
    ];

    public $timestamps = false;
}
