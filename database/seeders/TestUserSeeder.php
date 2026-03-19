<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing users first (optional - be careful in production)
        User::truncate();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin', // Add username
            'email' => 'admin@aspnoverseas.com',
            'phone' => '+1234567890',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'Regular User',
            'username' => 'user', // Add username
            'email' => 'user@aspnoverseas.com',
            'phone' => '+1234567891',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Create inactive user (for testing)
        User::create([
            'name' => 'Inactive User',
            'username' => 'inactive', // Add username
            'email' => 'inactive@aspnoverseas.com',
            'phone' => '+1234567892',
            'password' => Hash::make('password'),
            'is_active' => false,
        ]);

        $this->command->info('Test users created successfully!');
    }
}