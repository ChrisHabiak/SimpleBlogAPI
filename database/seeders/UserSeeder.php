<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

    User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Example User',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]
        );


        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Example Admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id' => 1
            ]
        );


        User::firstOrCreate(
            ['email' => 'editor@editor.com'],
            [
                'name' => 'Example Editor',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role_id' => 2
            ]
        );

    }
}
