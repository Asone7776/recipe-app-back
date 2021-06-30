<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RecipesController;
use App\Models\Role;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [ApiAuthController::class, 'login'])->name('login');
Route::post('/register', [ApiAuthController::class, 'register'])->name('register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout');

    Route::get('/current-user', function () {
        return Auth::user();
    });
    Route::resource('comments', CommentsController::class);
    Route::post('/comments/add-to-recipe/{id}', [CommentsController::class, 'addCommentForRecipe']);
});
Route::resource('recipes', RecipesController::class);
Route::resource('ingredients', IngredientsController::class);
Route::resource('roles', RolesController::class);
Route::resource('categories', CategoriesController::class);

Route::get('/role/{id}', function ($id) {
    return response()->json(Role::findOrFail($id)->users, 200);
});


