<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;
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
    Route::post('/ajax', [LevelController::class, 'store_ajax']); //menyimpan data user ajax terbaru

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

Route::group(['prefix'=>'barang'], function(){
    Route::get('/', [BarangController::class, 'index']); //menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']); //menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']); //menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']); //menyimpan data barang terbaru
    Route::get('/{id}', [BarangController::class, 'show']); //menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); //menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']); //menyimpan perubahan data barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); //menghapus data barang
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); //menampilkan halaman form tambah barang ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']); //menyimpan data barang ajax terbaru
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