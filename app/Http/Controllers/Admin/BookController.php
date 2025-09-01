<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        $genres = Genre::all();
        return view('pages.admin.bookForm', compact('genres'));
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
            'formats' => 'required|array|min:1',
            'formats.*' => 'in:soft cover,hard cover',
            'language' => 'required|string|max:100',
            'release_date' => 'required|date',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'weight' => 'required|integer',
            'page' => 'required|integer',
            'price' => 'required|integer|min:0',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id'
        ]);

        $bookData = collect($validatedData)->except('genres')->toArray();

        if ($request->hasFile('image')) {
            $originalTitle = $request->input('title');
            $slug = Str::slug($originalTitle);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $slug . '-' . uniqid() . '.' . $extension;
            $bookData['cover'] = $request->file('image')->storeAs('covers', $filename, 'public');
        } else {
            $validatedData['cover'] = null;
        }

        $book = Book::create($bookData);
        $book->genres()->sync($request->input('genres'));

        return redirect()->route('admin.books.index')->with('success', 'Book Succesfully Added!');
    }

    public function edit(Book $book)
    {
        $genres = Genre::all();
        return view('pages.admin.bookForm', compact('book', 'genres'));
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
            'formats' => 'required|array|min:1',
            'formats.*' => 'in:soft cover,hard cover',
            'language' => 'required|string|max:100',
            'release_date' => 'required|date',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'weight' => 'required|integer',
            'page' => 'required|integer',
            'price' => 'required|integer|min:0',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id'
        ]);

        $bookData = collect($validatedData)->except('genres')->toArray();

        if ($request->hasFile('image')) {
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            $originalTitle = $request->input('title');
            $slug = Str::slug($originalTitle);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = $slug . '-' . uniqid() . '.' . $extension;
            $bookData['cover'] = $request->file('image')->storeAs('covers', $filename, 'public');
        }

        $book->update($bookData);
        $book->genres()->sync($request->input('genres'));

        return redirect()->route('admin.books.index')->with('success', 'Book Successfully Edited');
    }

    public function destroy(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book Removed.');
    }
}
