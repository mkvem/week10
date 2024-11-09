<?php

use App\Http\Controllers\ShoppingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/details/{id}', [ShoppingController::class, 'show'])->name('productpage');
