<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Database\Factories\PostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PDO;
use Stringable;
use Illuminate\Support\Str;

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

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('test123')
        ]);

        $categories = ['IT news', "sport", 'travel', 'food & drinks'];
        foreach ($categories as $category) {
            Category::factory()->create([
                'title' => $category,
                "slug" => Str::slug($category),
                'user_id' => User::inRandomOrder()->first()->id
            ]);
        }

        $this->call(PostSeeder::class);
    }
}
