<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        //$faker->dateTime();
        //dd($users);
        $users = User::select('id')->pluck('id')->toArray();
        $categories = Category::select('id')->pluck('id')->toArray();
        //dd($users);
        //$users = User::select('id')->get();
        return [
            "title" => $this->faker->sentence,
            "user_id" => $this->faker->randomElement($users),
            "category_id" => $this->faker->randomElement($categories),
            "content" => $this->faker->paragraph,
            //"author" => $this->faker->name,
            "publish_date" => $this->faker->dateTimeBetween('-1 year', 'now'),
           // "category" => $this->faker->word,
           // "tags" => $this->faker->word
        ];


       
    }
}
