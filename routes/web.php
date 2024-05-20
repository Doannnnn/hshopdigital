<?php

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
    return view('admin.layout.dashboard');
});

Route::get('/login', function () {
    return view('auth.layout.login', ['title' => 'Đăng nhập']);
});

Route::get('/register', function () {
    return view('auth.layout.register', ['title' => 'Đăng ký']);
});

Route::get('/forgot-password', function () {
    return view('auth.layout.forgot-password', ['title' => 'Quên mật khẩu']);
});
