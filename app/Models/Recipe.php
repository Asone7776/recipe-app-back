<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'time_to_complete',
        'likes',
        'level_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('unit', 'count');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function details()
    {
        return $this->hasMany(RecipeDetail::class);
    }
}
