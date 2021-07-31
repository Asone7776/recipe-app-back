<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeDetail extends Model
{
    use HasFactory;

    protected $fillable = ['position', 'name', 'description'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
