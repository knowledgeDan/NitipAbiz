<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login/user', [LoginController::class, 'showUserLoginForm'])->name('login.user');
    Route::post('/login/user', [LoginController::class, 'loginUser']);
    Route::get('/login/seller', [LoginController::class, 'showSellerLoginForm'])->name('login.seller');
    Route::post('/login/seller', [LoginController::class, 'loginSeller']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::get('/login', function () {
    return redirect()->route('login.user');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/apply-courier', [ProfileController::class, 'applyCourier'])->name('profile.apply-courier');
});
