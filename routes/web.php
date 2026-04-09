<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index']);

Route::get('/posts/create', [PostController::class, 'create']);  
Route::post('/posts', [PostController::class, 'store']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);//open edit form
Route::put('/posts/{id}', [PostController::class, 'update']);//submit edited form
Route::post('/posts/{id}/comments', [PostController::class, 'storeComment']);