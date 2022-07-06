<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Nation;
use App\Models\Post;
use App\Models\User;
use Database\Factories\PostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $this->call([
            NationSeeder::class, UserSeeder::class,
            CategorySeeder::class, PostSeeder::class
        ]);
        $photos = Storage::allFiles('public');
        array_shift($photos); //shift git ingnore
        Storage::delete($photos); //clean Storage
        echo "\e[95mStorage Clean \n"; //echo terminal color
    }
}
