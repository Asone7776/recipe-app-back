<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {

        $data_to_return = [
            0 => [
                'type' => 'Рецепты',
                'value' => Recipe::all()->count()
            ],
            1 => [
                'type' => 'Ингредиенты',
                'value' => Ingredient::all()->count()
            ],
            2 => [
                'type' => 'Категории',
                'value' => Category::all()->count()
            ],
            3 => [
                'type' => 'Комментарии',
                'value' => Comment::all()->count()
            ],
            4 => [
                'type' => 'Тэги',
                'value' => Tag::all()->count()
            ],
            5 => [
                'type' => 'Пользователи',
                'value' => User::all()->count()
            ],
        ];
        return response()->json($data_to_return, 200);
    }
}
