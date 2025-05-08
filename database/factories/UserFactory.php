<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create regular users
        User::factory()->count(5)->create([
            'role' => 'User',
            'admin' => false
        ]);
        
        // Create admin user
        User::factory()->create([
            'role' => 'Admin',
            'admin' => true
        ]);
        
        $this->command->info('Users seeded successfully!');
    }
}