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

        // create user superadmin
        User::create([
            'name' => $faker->name,
            'email' => 'superadmin@dev',
            'password' => Hash::make('password'),
            'username' => $faker->username,
            'role' => 'superadmin',
            'email_verified_at' => now(),
            //'current_team_id' => 1,
        ]);

        // create user admin
        User::create([
            'name' => $faker->name,
            'email' => 'admin@dev',
            'password' => Hash::make('password'),
            'username' => $faker->username,
            'role' => 'admin',
            'email_verified_at' => now(),
            //'current_team_id' => 1,
        ]);
    }
}

