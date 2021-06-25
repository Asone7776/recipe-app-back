<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $recipes_id = DB::table('recipes')->pluck('id')->all();
        $user_id = DB::table('users')->pluck('id')->all();
        return [
            'message' => $this->faker->text,
            'recipe_id' => $this->faker->randomElement($recipes_id),
            'user_id' => $this->faker->randomElement($user_id),
        ];
    }
}
