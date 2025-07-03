<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('pages.admin.books', compact('books'));
    }

    public function create()
    {
        return view('pages.admin.bookForm');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publisher' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'format' => 'required|in:soft cover,hard cover',
            'language' => 'required|string|max:100',
            'release_date' => 'required|date',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'weight' => 'required|integer',
            'page' => 'required|integer',
            'price' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/covers');
            $validatedData['cover'] = str_replace('public/', 'storage/', $path);
        }

        Book::create($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Book Succesfully Added!');
    }

    public function edit(Book $book)
    {
        return view('pages.admin.bookForm', compact('book'));
    }

    public function show(Book $book)
    {
        return view('pages.admin.showBook', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'publisher' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'format' => 'required|in:soft cover,hard cover',
            'language' => 'required|string|max:100',
            'release_date' => 'required|date',
            'length' => 'required|numeric',
            'widht' => 'required|numeric',
            'weight' => 'required|integer',
            'page' => 'required|integer',
            'price' => 'required|integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/covers');
            $validatedData['cover'] = str_replace('public/', 'storage/', $path);
        }

        $book->update($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Book Successfully Edited');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book Removed.');
    }
}
