<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();

        foreach ($posts as $post) {
            Comment::factory(rand(1, 7))->make()->each(function ($comment) use ($post, $users) {
                $comment->post_id = $post->id;
                $comment->user_id = rand(1, 100) <= 80 ? $users->random()->id : null;
                $comment->save();
            });
        }
    }
}
