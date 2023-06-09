<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Comment\CreateCommentController;
use App\Http\Controllers\Comment\DeleteCommentController;
use App\Http\Controllers\Comment\ShowCommentController;
use App\Http\Controllers\Comment\ShowRecipeCommentsController;
use App\Http\Controllers\Recipe\CreateRecipeController;
use App\Http\Controllers\Recipe\DeleteRecipeController;
use App\Http\Controllers\Recipe\ShowRecipeController;
use App\Http\Controllers\Recipe\ShowRecipesController;
use App\Http\Controllers\Recipe\UpdateRecipeController;
use App\Http\Controllers\Recipe\UpdateRecipeImageController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\ShowUserController;
use App\Http\Controllers\User\UpdateImageController;
use App\Http\Controllers\User\UpdateLocationController;
use App\Http\Controllers\User\UpdateUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::prefix('user')->name('user.')->group(function(){
	Route::post('/', [CreateUserController::class, 'handle'])->name('create');
	Route::get('/{id}', [ShowUserController::class, 'handle'])->name('show');

	Route::group(['middleware' => 'jwt'], function(){
		Route::put('/', [UpdateUserController::class, 'handle'])->name('update');
		Route::put('/location', [UpdateLocationController::class, 'handle'])->name('updateLocation');
		Route::patch('/image', [UpdateImageController::class, 'handle'])->name('updateImage');
		Route::delete('/', [DeleteUserController::class, 'handle'])->name('delete');
	});
});

Route::prefix('recipe')->name('recipe.')->group(function (){

	Route::get('/', [ShowRecipesController::class, 'handle'])->name('all');
	Route::get('/{id}', [ShowRecipeController::class, 'handle'])->name('show');

	Route::group(['middleware' => 'jwt'], function(){
		Route::post('/', [CreateRecipeController::class, 'handle'])->name('create');
		Route::delete('/{id}', [DeleteRecipeController::class, 'handle'])->name('delete');
		Route::patch('/image/{id}', [UpdateRecipeImageController::class, 'handle'])->name('updateImage');
		Route::put('/{id}', [UpdateRecipeController::class, 'handle'])->name('update');
	});

});

Route::prefix('comment')->name('comment.')->group(function() {

	Route::get('/{id}', [ShowCommentController::class, 'handle'])->name('show');
	Route::get('/recipe/{id}', [ShowRecipeCommentsController::class, 'handle'])->name('showRecipeComments');

	Route::group(['middleware' => 'jwt'], function(){
		Route::post('/{recipeId}', [CreateCommentController::class, 'handle'])->name('create');
		Route::delete('/{id}', [DeleteCommentController::class, 'handle'])->name('delete');
	});

});

Route::prefix('auth')->name('auth.')->group(function(){
	Route::post('/login', [AuthenticateController::class, 'handle'])->name('login');
});


