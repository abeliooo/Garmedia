<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cartItems = $user->cartItems;

        return view('pages.cartPage', compact('cartItems'));
    }

    public function add(Book $book)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems();

        if ($cartItems->where('book_id', $book->id)->exists()) {
            $cartItems->updateExistingPivot($book->id, [
                'quantity' => \DB::raw('quantity + 1')
            ]);
        } else {
            $cartItems->attach($book->id, ['quantity' => 1]);
        }

        return response()->json(['status' => 'success', 'message' => 'Book added to cart.']);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        Auth::user()->cartItems()->updateExistingPivot($book->id, [
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart')->with('success', 'Cart updated successfully.');
    }

    public function remove(Book $book)
    {
        Auth::user()->cartItems()->detach($book->id);

        return redirect()->route('cart')->with('success', 'Book removed from cart.');
    }
}
