<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // プロフィール（Breeze標準）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 記事（CRUD）
    Route::resource('articles', ArticleController::class);

    // お気に入り
    Route::post('/articles/{article}/favorite', [FavoriteController::class, 'toggle'])
        ->name('articles.favorite.toggle');

    // レビュー
    Route::post('/articles/{article}/reviews', [ReviewController::class, 'store'])
        ->name('articles.reviews.store');

    // 閲覧履歴
    Route::get('/mypage/histories', [HistoryController::class, 'index'])
        ->name('histories.index');
});

require __DIR__.'/auth.php';