<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $products = collect();

        if ($query) {
            $products = Post::where('title', 'LIKE', "%{$query}%")
                ->orWhere('author', 'LIKE', "%{$query}%")
                ->get();
        }

        return view('pages.productsPage', [
            'products' => $products,
            'searchTerm' => $query
        ]);
    }
}
