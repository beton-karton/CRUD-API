<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Skill;

class Pokemon extends Model
{
    protected $table = 'pokemons';
    protected $fillable = [
        'sort',
        'name',
        'image',
        'shape',
        'location'
    ];

    public $timestamps = false;

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }


}
