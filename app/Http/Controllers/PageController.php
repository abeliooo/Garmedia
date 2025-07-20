<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.landingPage');
    }

    public function wishlist()
    {
        $user = User::find(Auth::id());

        $products = collect();
        $wishlistBookIds = [];

        if ($user) {
            $products = $user->wishlistBooks()->get();
            $wishlistBookIds = $products->pluck('id')->toArray();
        }

        return view('pages.wishlistPage', compact('products', 'wishlistBookIds'));
    }

    public function cart()
    {
        return view('pages.cartPage');
    }

    public function account()
    {
        $user = Auth::user();

        return view('pages.accountPage', compact('user'));
    }


    public function transaction()
    {
        return view('pages.transactionPage');
    }

    public function address()
    {
        return view('pages.addressPage');
    }

    public function review()
    {
        return view('pages.reviewPage');
    }

    public function products()
    {
        $products = Book::latest()->get();

        $wishlistBookIds = [];
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $wishlistBookIds = $user->wishlistBooks()->pluck('books.id')->toArray();
        }

        return view('pages.productsPage', [
            'products' => $products,
            'wishlistBookIds' => $wishlistBookIds
        ]);
    }

    public function productDetails(Book $book)
    {
        $wishlistBookIds = [];
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $wishlistBookIds = $user->wishlistBooks()->pluck('books.id')->toArray();
        }

        return view('components.productDetails', [
            'book' => $book,
            'wishlistBookIds' => $wishlistBookIds
        ]);
    }    
}
