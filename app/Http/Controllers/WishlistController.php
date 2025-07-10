<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggleWishlist(Book $book)
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        if ($user->wishlistBooks()->where('book_id', $book->id)->exists()) {
            $user->wishlistBooks()->detach($book->id);
            return back()->with('success', 'Removed from wishlist.');
        } else {
            $user->wishlistBooks()->attach($book->id);
            return back()->with('success', 'Added to wishlist.');
        }
    }
}
