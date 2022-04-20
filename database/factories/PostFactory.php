<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;

    public function definition()
    {
        $created_at = now()->subDays(rand(1, 20));
        $title = $this->faker->text(60);

        return [
            "user_id" => User::all()->random(1)->first()->id,
            "category_id" => Category::all()->random(1)->first()->id,
            "title" => $title,
            "content" => $this->faker->text(400),
            "likes" => rand(1, 20),
            "dislikes" => rand(1, 20),
            "created_at" => $created_at,
        ];
    }
}
