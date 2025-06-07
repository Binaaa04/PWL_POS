<?php

use App\Http\Controllers\api\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\UserController;
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

Route::get('/register1', RegisterController::class)->name('register1');
Route::post('/register1', RegisterController::class)->name('register1');

Route::post('/login', LoginController::class)->name('login');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/user', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::get('/user/{user}', [UserController::class, 'show']);
Route::put('/user/{user_id}', [UserController::class, 'update']);
Route::delete('/user/{user_id}', [UserController::class, 'destroy']);

Route::prefix('level')
    ->controller(LevelController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{level}', 'show');
    Route::put('/{level_id}', 'update');
    Route::delete('/{level_kode}', 'destroy');
});

Route::prefix('barang')
    ->controller(ItemController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{barang}', 'show');
    Route::put('/{barang_id}', 'update');
    Route::delete('/{barang_kode}', 'destroy');
});

Route::prefix('kategori')
    ->controller(CategoryController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{barang}', 'show');
    Route::put('/{barang_id}', 'update');
    Route::delete('/{barang_kode}', 'destroy');
});


Route::post('/logout', LogoutController::class)->name('login');