<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function(){
    return view('register');
});
Route::get('/login', function(){
    return view('login');
})->name('login.form');

Route::post('/user/store', [Usercontroller::class, "store"])->name("user.store");
Route::post('/user/login', [Usercontroller::class, "login"])->name("user.login");
Route::post('/user/update', [Usercontroller::class, "update"])->name("user.update");
Route::post('/user/update/password', [Usercontroller::class, "update_password"])->name("user.update.password");
Route::post('/user/logout', [Usercontroller::class, "logout"])->name("user.logout");

Route::get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');

Route::get('/setting/account', [UserController::class, "edit"])->name('setting.account');

