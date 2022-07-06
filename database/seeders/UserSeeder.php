<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => "admin"
        ]);

        User::factory()->create([
            'name' => 'editor',
            'email' => 'editor@gmail.com',
            'role' => "editor"
        ]);

        User::factory()->create([
            'name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'role' => "admin"
        ]);

        User::factory()->create([
            'name' => 'editor2',
            'email' => 'editor2@gmail.com',
            'role' => "editor"
        ]);
    }
}
