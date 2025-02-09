<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpendingController;
use App\Http\Controllers\IncomeController;

// Resourceful
Route::resource('incomes', IncomeController::class);
Route::resource('spendings', SpendingController::class);

// 他のルート
Route::get('/home', [HomeController::class, 'index'])->name('home');
