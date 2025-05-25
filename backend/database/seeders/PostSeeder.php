<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title' => 'The first post',
            'content' => 'This is content of the first post.'
        ]);

        Post::create([
            'title' => 'The second post',
            'content' => 'This is content of the second post.'
        ]);
    }
}
