<?php

use App\Livewire\Admin\Category\AddCategory;
use App\Livewire\Admin\Category\ListCategory;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Order\ListOrder;
use App\Livewire\Admin\Product\AddProduct;
use App\Livewire\Admin\Product\ListProduct;
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

Route::middleware(['auth', 'checkPermissions'])->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', Dashboard::class)->name('admin');

        Route::get('/profile', Profile::class)->name('profile');

        Route::prefix('/product')->group(function () {

            Route::get('/list', ListProduct::class)->name('product-list');

            Route::get('/add', AddProduct::class)->name('add-product');
        });

        Route::prefix('/category')->group(function () {

            Route::get('/list', ListCategory::class)->name('category-list');

            Route::get('/add', AddCategory::class)->name('add-category');
        });

        Route::prefix('/order')->group(function () {

            Route::get('/list', ListOrder::class)->name('order-list');
        });

        Route::prefix('/user')->group(function () {

            Route::get('/list', ListUser::class)->name('user-list')->middleware('checkRole:Admin');

            Route::get('/add', AddUser::class)->name('add-user')->middleware('checkRole:Admin');
        });
    });
});

Route::middleware('guest')->group(function () {

    Route::get('/login', Login::class)->name('login');

    Route::get('/register', Register::class)->name('register');

    Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
});
