<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/', [RegisterController::class, 'showLoginForm']);
Route::post('/', [RegisterController::class, 'login'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');


