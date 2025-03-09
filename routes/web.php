<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/adding', [UserController::class, 'adding'])->name('user.adding');
Route::post('/user/add_save', [UserController::class, 'add_save'])->name('user.add_save');

Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

