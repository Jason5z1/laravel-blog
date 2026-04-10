<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', PostController::class);
Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->middleware('auth');
