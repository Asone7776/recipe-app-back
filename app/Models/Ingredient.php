<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    const TYPE_GR = 0;
    const TYPE_KG = 1;
    const TYPE_SMALL_SPOON = 2;
    const TYPE_BIG_SPOON = 3;
    const TYPE_LEAF = 4;
    const TYPE_TASTE = 5;

    protected $fillable = ['name', 'description'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class);
    }
}
