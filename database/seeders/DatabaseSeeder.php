<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comment;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\Level;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'subscriber', 'moderator'];
        $levels = ['Простой', 'Средний', 'Сложный'];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
        foreach ($levels as $level) {
            Level::create([
                'name' => $level
            ]);
        }

        User::factory(10)->create();
        Ingredient::factory(10)->create();
        Tag::factory(10)->create();
        Recipe::factory(10)->create();
        Comment::factory(10)->create();
        Category::factory(10)->create();
    }
}
