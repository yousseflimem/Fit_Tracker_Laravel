<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create regular users (password will be 'password' from factory)
        User::factory()
            ->count(10)
            ->create();

        // Create specific admin users
        User::factory()
            ->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'), // Stronger password for admin
                'role' => 'admin'
            ]);

        $this->command->info('Successfully seeded users (10 regular + 1 admin)');
    }
}
?>