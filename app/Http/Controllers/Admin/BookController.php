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
                return $query->where('judul', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10); // Menampilkan 10 buku per halaman

        return view('pages.admin.books', compact('books'));
    }

    public function create()
    {
        return view('pages.admin.books.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'format' => 'required|in:soft cover,hard cover',
            'bahasa' => 'required|string|max:100',
            'tanggal_terbit' => 'required|date',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'berat' => 'required|integer',
            'halaman' => 'required|integer',
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/covers');
            $validatedData['cover'] = str_replace('public/', 'storage/', $path);
        }

        Book::create($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        return view('pages.admin.books.edit', compact('book'));
    }

    public function show(Book $book)
    {
        return view('pages.admin.showBook', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'format' => 'required|in:soft cover,hard cover',
            'bahasa' => 'required|string|max:100',
            'tanggal_terbit' => 'required|date',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'berat' => 'required|integer',
            'halaman' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/covers');
            $validatedData['cover'] = str_replace('public/', 'storage/', $path);
        }

        $book->update($validatedData);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
