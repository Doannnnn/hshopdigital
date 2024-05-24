<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Profile;
use App\Livewire\Admin\User\AddUser;
use App\Livewire\Admin\User\ListUser;
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

Route::get('/', function () {
    return redirect()->route('admin');
});

Route::get('/logout', [Login::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', Dashboard::class)->name('admin');

        Route::get('/profile', Profile::class)->name('profile');

        Route::prefix('/user')->group(function () {

            Route::get('/list', ListUser::class)->name('user-list');

            Route::get('/add', AddUser::class)->name('add-user');
        });
    });
});

Route::middleware('guest')->group(function () {

    Route::get('/login', Login::class)->name('login');

    Route::get('/register', Register::class)->name('register');

    Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
});
