<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $levels = DB::table('levels')->pluck('id')->all();
        return [
            'name' => $this->faker->realText('20'),
            'description' => $this->faker->text,
            'time_to_complete' => $this->faker->date(),
            'likes' => $this->faker->randomDigit,
            'level_id' => $this->faker->randomElement($levels)
        ];
    }
}
