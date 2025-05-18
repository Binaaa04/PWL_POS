<?php

use Monolog\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\api\LevelController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\LogoutController;
use App\Http\Controllers\api\RegisterController;

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

Route::post('/register', RegisterController::class)->name('register');

Route::post('/login', LoginController::class)->name('login');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('user')
    ->controller(UserController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{user}', 'show');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'destroy');
});

Route::prefix('level')
    ->controller(LevelController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{user}', 'show');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'destroy');
});

Route::post('/logout', LogoutController::class)->name('login');