<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        User::create([
            'name' => $faker->name,
            'email' => 'admin@dev',
            'password' => Hash::make('password'),
            'username' => $faker->username,
            'role' => 'superadmin',
            'curent_team_id' => 1,
        ]);
    }
}

