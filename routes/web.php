<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SpendingController;
use App\Http\Controllers\IncomeController;

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\RegistrationController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/hello', [HelloController::class, 'index']);
// Route::get('/', [DisplayController::class, 'index']);
// Route::get('home', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/spendings', [SpendingController::class, 'index']);
Route::post('/spendings', [SpendingController::class, 'store']);
Route::get('/incomes', [IncomeController::class, 'index']);
Route::post('/incomes', [IncomeController::class, 'store']);
