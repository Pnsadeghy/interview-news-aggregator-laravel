<?php

use \App\Http\Controllers\AuthController;
use App\Http\Controllers\User\ArticlesController;
use App\Http\Controllers\User\UserFeedsController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', 'logout')->name('logout');
    });
});

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth:sanctum'])->group(function () {
        Route::post("articles/feed", [ArticlesController::class, "feed"])->name("articles.feed");
        Route::post("articles", [ArticlesController::class, "index"])->name("articles.index");

        Route::put("userFeed/config", [UserFeedsController::class, "updateConfig"])->name("userFeeds.update.config");
        Route::apiSingleton("userFeed", UserFeedsController::class)->only(["show"]);
});
