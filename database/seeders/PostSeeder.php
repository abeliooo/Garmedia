<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $products = [
            [
                'image' => 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg',
                'title' => 'Seni untuk Bersikap Bodo Amat',
                'author' => 'Mark Manson',
                'price' => 98000
            ],
            [
                'image' => 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg',
                'title' => 'Sebuah Seni untuk Memahami Perasaan',
                'author' => 'Peurih',
                'price' => 85000
            ],
            [
                'image' => 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg',
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'price' => 105000
            ],
            [
                'image' => 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg',
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'price' => 110000
            ],
        ];

        foreach ($products as $product) {
            Post::create([
                'title'   => $product['title'],
                'author'  => $product['author'],
                'slug'    => Str::slug($product['title']),
                'content' => 'dummy content' . $product['title'],
                'image'   => $product['image'],
                'price'   => $product['price'],
            ]);
        }
    }
}
