<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

Route::pattern('id','[0-9+]');
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('login',[AuthController::class,'postlogin']);
Route::get('/', [WelcomeController::class,'index']);
Route::get('logout',[AuthController::class,'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function(){
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

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);
    Route::get('/{id}', [LevelController::class, 'show']);
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    Route::put('/{id}', [LevelController::class, 'update']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
    Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix'=>'penjualan'], function(){
    Route::get('/', [PenjualanController::class, 'index']); //menampilkan halaman awal penjualan
    Route::post('/list', [PenjualanController::class, 'list']); //menampilkan data penjualan dalam bentuk json untuk datatables
    Route::get('/create', [PenjualanController::class, 'create']); //menampilkan halaman form tambah penjualan
    Route::post('/', [PenjualanController::class, 'store']); //menyimpan data penjualan terbaru
    Route::get('/{id}', [PenjualanController::class, 'show']); //menampilkan detail penjualan
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']); //menampilkan halaman form edit penjualan
    Route::put('/{id}', [PenjualanController::class, 'update']); //menyimpan perubahan data penjualan
    Route::delete('/{id}', [PenjualanController::class, 'destroy']); //menghapus data penjualan
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']); //menampilkan halaman form tambah penjualan ajax
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']); //menyimpan data penjualan ajax terbaru
});

Route::group(['prefix'=>'stok'], function(){
    Route::get('/', [StokController::class, 'index']); //menampilkan halaman awal penjualan
    Route::post('/list', [StokController::class, 'list']); //menampilkan data penjualan dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']); //menampilkan halaman form tambah penjualan
    Route::post('/', [StokController::class, 'store']); //menyimpan data penjualan terbaru
    Route::get('/{id}', [StokController::class, 'show']); //menampilkan detail penjualan
    Route::get('/{id}/edit', [StokController::class, 'edit']); //menampilkan halaman form edit penjualan
    Route::put('/{id}', [StokController::class, 'update']); //menyimpan perubahan data penjualan
    Route::delete('/{id}', [StokController::class, 'destroy']); //menghapus data penjualan
    Route::get('/create_ajax', [StokController::class, 'create_ajax']); //menampilkan halaman form tambah penjualan ajax
    Route::post('/ajax', [StokController::class, 'store_ajax']); //menyimpan data penjualan ajax terbaru
});

Route::group(['prefix'=>'detail'], function(){
    Route::get('/', [DetailController::class, 'index']); //menampilkan halaman awal penjualan
    Route::post('/list', [DetailController::class, 'list']); //menampilkan data penjualan dalam bentuk json untuk datatables
    Route::get('/create', [DetailController::class, 'create']); //menampilkan halaman form tambah penjualan
    Route::post('/', [DetailController::class, 'store']); //menyimpan data penjualan terbaru
    Route::get('/{id}', [DetailController::class, 'show']); //menampilkan detail penjualan
    Route::get('/{id}/edit', [DetailController::class, 'edit']); //menampilkan halaman form edit penjualan
    Route::put('/{id}', [DetailController::class, 'update']); //menyimpan perubahan data penjualan
    Route::delete('/{id}', [DetailController::class, 'destroy']); //menghapus data penjualan
    Route::get('/create_ajax', [DetailController::class, 'create_ajax']); //menampilkan halaman form tambah penjualan ajax
    Route::post('/ajax', [DetailController::class, 'store_ajax']); //menyimpan data penjualan ajax terbaru
});
});