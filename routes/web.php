<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;

Route::get('/', [PageController::class, 'home']);
Route::get('/wishlist', [PageController::class, 'wishlist']);
Route::get('/cart', [PageController::class, 'cart']);
Route::get('/account', [PageController::class, 'account']);
Route::get('/transaction', [PageController::class, 'transaction']);
Route::get('/address', [PageController::class, 'address']);
Route::get('/review', [PageController::class, 'review']);
Route::get('/products', [PageController::class, 'products']);
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/{post:slug}', [PostController::class, 'show']);
