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
        'likes'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        $this->belongsToMany(Tag::class);
    }

    public function ingredients()
    {
        $this->belongsToMany(Ingredient::class);
    }

    public function categories()
    {
        $this->belongsToMany(Category::class);
    }
}
