<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/products', [PageController::class, 'products'])->name('products.index');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/landing', [PageController::class, 'home'])->name('landing');
    Route::get('/wishlist', [PageController::class, 'wishlist'])->name('wishlist');
    Route::get('/cart', [PageController::class, 'cart'])->name('cart');
    Route::get('/account', [PageController::class, 'account'])->name('account');
    Route::get('/transaction', [PageController::class, 'transaction'])->name('transaction');
    Route::get('/address', [PageController::class, 'address'])->name('address');
    Route::get('/review', [PageController::class, 'review'])->name('review');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('books', BookController::class);
});

Route::get('/{post:slug}', [BookController::class, 'show'])->name('posts.show');
