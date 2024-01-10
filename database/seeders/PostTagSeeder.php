<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Get all the tags attaching up to 3 random tags to each post
        $tags = Tag::all();
        //"user_id" => $this->faker->randomElement($users),
        // Populate the pivot table
        Post::all()->each(function ($post) use ($tags) {
           $post->tags()->attach(
               $tags->random(rand(1, 4))->pluck('id')->toArray()
           );
       });
    }
}
