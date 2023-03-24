<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\ShowUserController;
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
	});
});

Route::prefix('auth')->name('auth.')->group(function(){
	Route::post('/login', [AuthenticateController::class, 'handle'])->name('login');
});


