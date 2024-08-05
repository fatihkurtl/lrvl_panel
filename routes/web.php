<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CustomersController;

Route::get('/giris', [AuthController::class, 'loginIndex'])->name('admin-login');
Route::post('/giris', [AuthController::class, 'login'])->name('admin-login-create');

Route::get('/uye-ol', [AuthController::class, 'registerIndex'])->name('admin-register');
Route::post('/uye-ol', [AuthController::class, 'register'])->name('admin-register-create');

Route::get('/cikis', [AuthController::class, 'logout'])->name('admin-logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-dashboard');
    Route::get('/musteriler', [CustomersController::class, 'index'])->name('admin-customers');
    Route::get('/faturalar', [AdminController::class, 'invoicesIndex'])->name('admin-invoices');
    Route::get('/urunler', [ProductController::class, 'index'])->name('products');

    Route::get('/urun/ekle', [ProductController::class, 'create'])->name('create-product');
    Route::post('/urun/ekle', [ProductController::class, 'store'])->name('store-product');

    Route::get('/urun/{product}', [ProductController::class, 'edit'])->name('edit-product');
    Route::put('/urun/{product}', [ProductController::class, 'update'])->name('update-product');
});


require __DIR__ . '/auth.php';
