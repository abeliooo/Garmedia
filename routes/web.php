<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
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
Route::get('/product/{book}', [PageController::class, 'productDetails'])->name('product.detail');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/landing', [PageController::class, 'home'])->name('landing');
    Route::get('/wishlist', [PageController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist/toggle/{book}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
    Route::get('/cart', [PageController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{bozok}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update-field', [AccountController::class, 'updateField'])->name('account.update.field');
    Route::post('/account/update-password', [AccountController::class, 'updatePassword'])->name('account.update.password');
    Route::post('/account/update-picture', [AccountController::class, 'updatePicture'])->name('account.update.picture');
    Route::get('/transaction', [PageController::class, 'transaction'])->name('transaction');
    Route::get('/address', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/address/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/address', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/address/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/address/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/address/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::get('/review', [PageController::class, 'review'])->name('review');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('books', BookController::class);
});

Route::get('/cover/{filename}', function ($filename) {
    $path = storage_path('app/public/covers/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file)->header("Content-Type", $type);
});
