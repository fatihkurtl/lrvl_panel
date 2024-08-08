<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::post('/add-to-cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
// Route::post('/update-cart', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
// Route::post('/remove-from-cart', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
