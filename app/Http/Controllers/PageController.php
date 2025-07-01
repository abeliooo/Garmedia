<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        return view('pages.wishlistPage');
    }

    public function cart()
    {
        return view('pages.cartPage');
    }

    public function account()
    {
        return view('pages.accountPage');
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
        $products = Post::latest()->get();

        return view('pages.productsPage', ['products' => $products]);
    }
}
