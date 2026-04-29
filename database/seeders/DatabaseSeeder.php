<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@vote.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Voter One',
            'email' => 'voter1@vote.com',
            'password' => bcrypt('password'),
            'role' => 'voter',
        ]);

        User::create([
            'name' => 'Voter Two',
            'email' => 'voter2@vote.com',
            'password' => bcrypt('password'),
            'role' => 'voter',
        ]);
    }
}
