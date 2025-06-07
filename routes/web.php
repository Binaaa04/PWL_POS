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

Route::pattern('id', '[0-9]+');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin']);
Route::get('/registration', fn() => view('auth.registration'))->name('registration');
Route::post('/registration', [AuthController::class, 'postregister'])->name('registration');
Route::get('/', [WelcomeController::class, 'index']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Middleware 'auth' group
Route::middleware(['auth'])->group(function () {

    // User routes
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/store_ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::get('/{id}/edit', [UserController::class, 'edit']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // Admin only
    Route::middleware(['authorize:Admin'])->group(function () {
        Route::prefix('level')->group(function () {
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
            Route::delete('/{id}', [LevelController::class, 'destroy']);
        });

        Route::prefix('kategori')->group(function () {
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
    });

    // Admin & Staff
    Route::middleware(['authorize:Admin,STF'])->group(function () {
        Route::prefix('barang')->group(function () {
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
            Route::get('/import', [BarangController::class, 'import']);
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
            Route::get('/export_excel', [BarangController::class, 'export_excel']);
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']);
        });
    });

    // Stok - Staff only
    Route::middleware(['authorize:STF'])->group(function (): void {
        Route::prefix('stok')->group(function () {
            Route::get('/', [StokController::class, 'index']);
            Route::post('/list', [StokController::class, 'list']);
            Route::get('/create', [StokController::class, 'create']);
            Route::post('/', [StokController::class, 'store']);
            Route::get('/{id}', [StokController::class, 'show']);
            Route::get('/{id}/edit', [StokController::class, 'edit']);
            Route::put('/{id}', [StokController::class, 'update']);
            Route::delete('/{id}', [StokController::class, 'destroy']);
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);
            Route::post('/ajax', [StokController::class, 'store_ajax']);
        });
    });

    // Detail - Staff & Customer
    Route::middleware(['authorize:STF,CST'])->group(function () {
        Route::prefix('detail')->group(function () {
            Route::get('/', [DetailController::class, 'index']);
            Route::post('/list', [DetailController::class, 'list']);
            Route::get('/create', [DetailController::class, 'create']);
            Route::post('/', [DetailController::class, 'store']);
            Route::get('/{id}', [DetailController::class, 'show']);
            Route::get('/{id}/edit', [DetailController::class, 'edit']);
            Route::put('/{id}', [DetailController::class, 'update']);
            Route::delete('/{id}', [DetailController::class, 'destroy']);
            Route::get('/create_ajax', [DetailController::class, 'create_ajax']);
            Route::post('/ajax', [DetailController::class, 'store_ajax']);
        });
    });

    // Penjualan (semua auth user)
    Route::prefix('penjualan')->group(function () {
        Route::get('/', [PenjualanController::class, 'index']);
        Route::post('/list', [PenjualanController::class, 'list']);
        Route::get('/create', [PenjualanController::class, 'create']);
        Route::post('/', [PenjualanController::class, 'store']);
        Route::get('/{id}', [PenjualanController::class, 'show']);
        Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
        Route::put('/{id}', [PenjualanController::class, 'update']);
        Route::delete('/{id}', [PenjualanController::class, 'destroy']);
        Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']);
        Route::post('/ajax', [PenjualanController::class, 'store_ajax']);
    });

    // Profile
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/profile/update-picture', [UserController::class, 'updateProfilePicture']);
});
