<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'index'])->name('page.index');

Route::get('/detail/{slug}', [PageController::class, 'detail'])->name('page.detail');

Route::get('/category/{category:slug}', [PageController::class, 'postsByCategory'])->name('page.category');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::resource('/post', PostController::class);

    Route::resource('/category', CategoryController::class);

    Route::resource('/nation', NationController::class);

    Route::resource('/photo', PhotoController::class);

    Route::resource('/user', UserController::class)->middleware('isAdmin');
});
