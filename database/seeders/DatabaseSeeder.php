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
        // User::factory(10)->create();
        $this->call(
            [
                PostSeeder::class,
            ]
        );
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@garmedia.com',
            'password' => bcrypt('admin123'),
            'phone_number' => '081200000001',
            'gender' => 'male',
            'role' => 'admin',
            'admin_id' => 'ADM001'
        ]);
        User::factory(10)->create();
    }
}
