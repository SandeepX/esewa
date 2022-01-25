<?php

use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/carts','App\Http\Controllers\CartController');

Route::get('/verification-payment',[App\Http\Controllers\CartController::class,'verify'])->name('payment-verfiy');
    

