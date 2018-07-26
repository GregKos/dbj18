<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Post::class, 200)->create();

        $categories = App\Category::all();
        App\Post::all()->each(function ($post) use ($categories) {
            $post->categories()->attach($categories->random(rand(1, 15))->pluck('id')->toArray());
        });
    }
}
