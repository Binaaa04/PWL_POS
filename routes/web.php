<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix'=>'user'], function(){
    Route::get('/', [UserController::class, 'index']); //menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); //menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); //menyimpan data user terbaru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); //menampilkan halaman form tambah user ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); //menyimpan data user ajax terbaru
    Route::get('/{id}', [UserController::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); //menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); //menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //menampilkan halaman form edit user AJAX
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //menyimpan perubahan data user AJAX
    Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //menampilkan halaman form confirm delete user AJAX
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //menghapus data user AJAX
});

Route::group(['prefix'=>'level'], function(){
    Route::get('/', [LevelController::class, 'index']); //menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']); //menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']); //menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']); //menyimpan data level terbaru
    Route::get('/{id}', [LevelController::class, 'show']); //menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); //menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']); //menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']); //menghapus data level
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); //menampilkan halaman form tambah level ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']); //menyimpan data level ajax terbaru
});

Route::group(['prefix'=>'kategori'], function(){
    Route::get('/', [KategoriController::class, 'index']); //menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']); //menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']); //menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']); //menyimpan data kategori terbaru
    Route::get('/{id}', [KategoriController::class, 'show']); //menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); //menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']); //menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); //menghapus data kategori
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); //menampilkan halaman form tambah kategori ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']); //menyimpan data kategori ajax terbaru
});


