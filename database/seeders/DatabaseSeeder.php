<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Your Admin Account
        User::updateOrCreate(
            ['email' => 'nalubwamajoanjojo@gmail.com'],
            [
                'name' => 'Joan Nalubwama',
                'password' => Hash::make('nalu123@'),
                'role' => 'administrator',
                'status' => 'active',
                'rules_accepted_at' => now(),
            ]
        );

        // 2. Put your actual LECTURER credentials here:
        User::updateOrCreate(
            ['email' => 'put-your-lecturer-email@gmail.com'], // <-- Change to your lecturer's email
            [
                'name' => 'Lecturer Name Here',               // <-- Change to your lecturer's name
                'password' => Hash::make('password123'),     // <-- Set their password
                'role' => 'lecturer',
                'status' => 'active',
                'rules_accepted_at' => now(),
            ]
        );

        // 3. Put your actual STUDENT credentials here:
        User::updateOrCreate(
            ['email' => 'put-your-student-email@gmail.com'],   // <-- Change to your student's email
            [
                'name' => 'Student Name Here',                 // <-- Change to your student's name
                'password' => Hash::make('password123'),       // <-- Set their password
                'role' => 'student',
                'status' => 'active',
                'rules_accepted_at' => now(),
            ]
        );
        
        // Add as many actual users as you want here...
    }
}