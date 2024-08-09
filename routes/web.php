<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Customers\CustomersController;
use App\Http\Controllers\Admin\CustomersController as AdminCustomersController;
use App\Http\Controllers\Customers\OrdersController;
use App\Http\Controllers\Customers\ProductsController as CustomerProductsController;



Route::prefix('admin')->group(function () {
    Route::get('/giris', [AuthController::class, 'loginIndex'])->name('admin-login');
    Route::post('/giris', [AuthController::class, 'login'])->name('admin-login-create');

    Route::get('/uye-ol', [AuthController::class, 'registerIndex'])->name('admin-register');
    Route::post('/uye-ol', [AuthController::class, 'register'])->name('admin-register-create');

    Route::get('/cikis', [AuthController::class, 'logout'])->name('admin-logout');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
        Route::get('/musteriler', [AdminCustomersController::class, 'index'])->name('admin-customers');
        Route::get('/faturalar', [AdminController::class, 'invoicesIndex'])->name('admin-invoices');
        Route::get('/urunler', [ProductController::class, 'index'])->name('admin-products');

        Route::get('/urun/ekle', [ProductController::class, 'create'])->name('admin-create-product');
        Route::post('/urun/ekle', [ProductController::class, 'store'])->name('admin-store-product');

        Route::get('/urun/{product}', [ProductController::class, 'edit'])->name('admin-edit-product');
        Route::put('/urun/{product}', [ProductController::class, 'update'])->name('admin-update-product');
    });
});


Route::get('/', [CustomersController::class, 'index'])->name('customers-index');
Route::get('/magaza/{category?}', [CustomerProductsController::class, 'index'])->name('customers-store');

Route::get('/urun/{id}', [CustomerProductsController::class, 'productDetailIndex'])->name('product-detail');

Route::post('/sepete-ekle', [CustomerProductsController::class, 'addCart'])->name('add-to-cart');

Route::get('/sepet', function () {
    return view('layouts.customers.cartLayout');
});

Route::get('/siparislerim', [OrdersController::class, 'index'])->name('orders-index');

Route::get('/odeme', [CustomersController::class, 'paymentIndex'])->name('customers-payment');

Route::get('/siparisler/ozet/{id}', [OrdersController::class, 'orderSummaryIndex'])->name('orders-summary');

Route::get('/siparislerim/{id}', [OrdersController::class, 'orderConfirmationIndex'])->name('orders-show');
Route::get('/siparislerim/takip/{id}', [OrdersController::class, 'orderTrackingIndex'])->name('orders-tracking');

require __DIR__ . '/auth.php';
