<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        try {
            // disable foreign key constraints
            Schema::disableForeignKeyConstraints();
            User::truncate();
            Tag::truncate();
            Category::truncate();
            Post::truncate();
            // enable foreign key constraints
            Schema::enableForeignKeyConstraints();
            $this->call([
                UserSeeder::class,
                TagSeeder::class,
                CategorySeeder::class,
                PostSeeder::class,
                PostTagSeeder::class,
            ]);

        } catch (Exception $ex) {
            Log::error($ex);
        }
    }
}
