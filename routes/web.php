<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[ProductController::class,'index'])->name('products.index');
Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
Route::post('/products',[ProductController::class,'store'])->name('products.store');
Route::get('/products/edit/{product}',[ProductController::class,'edit'])->name('products.edit');
Route::put('/products/{product}',[ProductController::class,'update'])->name('products.update');
// Route::post('/products/destroy',[ProductController::class,'destroy'])->name('products.destroy');
Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('products.destroy');