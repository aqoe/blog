<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\LoginController;

// Авторизация
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Главная страница — список постов
Route::get('/', [PostController::class, 'index'])->name('home');

// Отдельный пост
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');

// Посты по категории
Route::get('/category/{slug}', [PostController::class, 'category'])->name('category.show');

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Админ-панель (только для авторизованных)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('posts', AdminPostController::class);
    Route::resource('categories', AdminCategoryController::class);
});