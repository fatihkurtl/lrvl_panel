<?php

use App\Http\Controllers\Customers\Api\CartController;
use App\Http\Controllers\Customers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/cart-items', [CartController::class, 'index'])->name('cart.items');
Route::put('/update/cart-items/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/delete/cart-items/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
// Route::post('/add-to-cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
// Route::post('/update-cart', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
// Route::post('/remove-from-cart', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
