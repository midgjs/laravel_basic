<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::controller(ArticleController::class)->group(function() {
    Route::get('/articles/create', 'create')->name('articles.create'); //->->middleware('auth')
    Route::post('/articles/store', 'store')->name('articles.store');
    Route::get('articles', 'index')->name('articles.index');
    Route::get('articles/{article}', 'show')->name('articles.show');
    Route::get('articles/{article}/edit', 'edit')->name('articles.edit');
    Route::post('articles/{article}/update', 'update')->name('articles.update');
    Route::post('articles/{article}/delete', 'delete')->name('articles.delete');
});

// Route::resource('articles', ArticleController::class)->except(['destroy','update']);

Route::resource('comments', CommentController::class);

Route::get('profile/{user:username}', [ProfileController::class, 'show'])
->name('profile')
->where('user', '^[ㄱ-ㅎ가-힣A-Za-z0-9-]+$');

Route::post('follow/{user}', [FollowController::class, 'store'])->name('follow');
Route::post('unfollow/{user}', [FollowController::class, 'delete'])->name('unfollow');