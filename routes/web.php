<?php

use Illuminate\Support\Facades\Route;

//使用するコントローラ
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserIconController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThreadController;

//使用するミドルウェア
use App\Http\Middleware\AuthMiddleware;

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
Route::post('/user/delete', [Usercontroller::class, "destroy"])->name("user.delete");

Route::get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');

Route::get('/setting/account', [UserController::class, "edit"])->name('setting.account');

//ユーザーアイコン関係のルーティング（UserIconControllerを使用）
Route::post('/usericon/update', [UserIconController::class, "update"])->name('usericon.update');


//マップ機能関係のルーティング（MapControllerを使用）
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::post('/map/store', [MapController::class, 'store'])->name('map.store');


//掲示板関係のルーティング（PostController,ThreadControllerを使用）
Route::middleware(AuthMiddleware::class)->group(function(){
    Route::get('/timeline', [PostController::class, "index"])->name('timeline');
    Route::post('/post/store', [PostController::class, "store"])->name('post.store');
    Route::get('/post/create', [PostController::class, "create"])->name('post.create');
    Route::get('/post/show/{id}', [PostController::class, "show"])->name('post.show');
    Route::post('/post/search', [PostController::class, "search"])->name('post.search');

    Route::get('/thread/create/{id}', [ThreadController::class, "create"])->name('thread.create');
    Route::post('/thread/store/{id}', [ThreadController::class, "store"])->name('thread.store');

});
