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
});

Route::post('/user/store', [Usercontroller::class, "store"])->name("dashboard.store");
Route::post('/user/login', [Usercontroller::class, "login"])->name("dashboard.login");
Route::post('/user/logout', [Usercontroller::class, "logout"])->name("dashboard.logout");

Route::get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');

