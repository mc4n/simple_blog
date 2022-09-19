<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', AboutController::class)->name('about');

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('tags', TagController::class);
});

Auth::routes(['register' => false, 'reset' => false]);
