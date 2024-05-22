<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Profile;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', Dashboard::class)->name('admin');

        Route::get('/profile', Profile::class)->name('profile');
    });
});

Route::get('/logout', [Login::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {

    Route::get('/login', Login::class)->name('login');

    Route::get('/register', Register::class)->name('register');

    Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
});
