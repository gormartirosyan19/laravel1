<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\RolesEnum;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        $admin = User::create([
            'name' => 'Gor Martirosyan',
            'email' => 'gmartirosyan241202@gmail.com',
            'password' => bcrypt('88888888'),
        ]);
        $admin->assignRole(RolesEnum::ADMIN);

        // Moderator User
        $moderator = User::create([
            'name' => 'Moderator User',
            'email' => 'gor_martirosyan_00@mail.ru',
            'password' => bcrypt('password'),
        ]);
        $moderator->assignRole(RolesEnum::MODERATOR);

        // Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'), // Change this to a secure password
        ]);
        $user->assignRole(RolesEnum::USER);

        $this->command->info('Users have been seeded!');
    }
}
