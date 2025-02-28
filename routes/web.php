<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::prefix('merchant')->name('merchants.')->group(function () {

    Route::middleware(['merchant', 'verified'])->group(function () {
        Route::view('/', 'merchant.pages.index')->name('index');
    });
    require __DIR__ . '/merchantAuth.php';
    // Route::view('/login', 'merchant.auth.pages.login')->name('login');
    // Route::view('/register', 'merchant.auth.pages.register')->name('register');
});



