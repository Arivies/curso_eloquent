<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Tag::factory(20)->create();
        Category::factory(5)->create();
        Post::factory(50)->create()->each(function (Post $post) {
            $numberOfTags = rand(0, 3);
            if ($numberOfTags) {
                $post->tags()->sync(Tag::all()->random($numberOfTags)->pluck("id"));
            }
        });
    }
}
