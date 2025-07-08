<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store']);
    Route::post('/like-comment', [LikeController::class, 'storeComment']);
    Route::post('/like-project', [LikeController::class, 'storeProject']);
});