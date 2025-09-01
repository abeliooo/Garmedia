<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $books = Book::query()
            ->when($query, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                })
                    ->orWhereHas('genres', function ($genreQuery) use ($search) {
                        $genreQuery->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(12);

        $wishlistBookIds = [];
        if (Auth::check()) {
            $wishlistBookIds = Auth::user()->wishlistBooks()->pluck('book_id')->toArray();
        }

        return view('pages.productsPage', [
            'products' => $books,
            'wishlistBookIds' => $wishlistBookIds,
            'query' => $query
        ]);
    }
}
