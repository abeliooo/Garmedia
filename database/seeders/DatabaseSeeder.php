<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            BookSeeder::class,
        );
        User::create(
            [
                'name' => 'Super Admin',
                'email' => 'admin@garmedia.com',
                'password' => bcrypt('admin123'),
                'phone_number' => '081200000001',
                'gender' => 'male',
                'role' => 'admin',
                'admin_id' => 'ADM001'
            ],
        );

        User::create([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => bcrypt('1123411234'),
            'phone_number' => '081200000002',
            'gender' => 'female',
            'role' => 'user',
            'admin_id' => null,
        ]);

        User::factory(10)->create();
    }
}
