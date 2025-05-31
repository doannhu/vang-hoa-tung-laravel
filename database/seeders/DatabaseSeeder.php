<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'doan',
            'email' => 'doan@mail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->call([
            AdminUserSeeder::class,
            GoldPriceSeeder::class,
            FeaturedProductSeeder::class,
            CatalogueSeeder::class,
            PromotionSeeder::class,
            BlogPostSeeder::class,
        ]);
    }
}
