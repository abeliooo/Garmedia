<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/books.json');
        $books = json_decode(File::get($jsonPath), true);

        foreach ($books as $bookData) {
            $tempCoverPath = storage_path("app/public/temp-covers/" . $bookData['cover']);
            $slug = Str::slug($bookData['title']);
            $extension = pathinfo($bookData['cover'], PATHINFO_EXTENSION);
            $finalCoverName = $slug . '-' . uniqid() . '.' . $extension;
            $finalCoverPath = "covers/" . $finalCoverName;

            if (file_exists($tempCoverPath)) {
                Storage::disk('public')->put($finalCoverPath, file_get_contents($tempCoverPath));
                unlink($tempCoverPath);
            } else {
                continue;
            }

            $genreNames = array_map('trim', explode(',', $bookData['genre']));
            $genreIds = [];
            foreach ($genreNames as $genreName) {
                $genre = Genre::firstOrCreate(['name' => $genreName]);
                $genreIds[] = $genre->id;
            }

            $book = Book::create([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'formats' => $bookData['formats'],
                'description' => $bookData['description'],
                'publisher' => $bookData['publisher'],
                'isbn' => $bookData['isbn'],
                'language' => $bookData['language'],
                'length' => $bookData['length'],
                'width' => $bookData['width'],
                'weight' => $bookData['weight'],
                'page' => $bookData['page'],
                'release_date' => $bookData['release_date'],
                'price' => $bookData['price'],
                'cover' => $finalCoverName,
            ]);

            $book->genres()->sync($genreIds);
        }
    }
}
