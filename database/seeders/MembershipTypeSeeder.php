<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MembershipType;

class MembershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MembershipType::create([
            'name' => 'Basic Plan',
            'durationInDays' => 30,
            'price' => 19.99,
        ]);

        MembershipType::create([
            'name' => 'Standard Plan',
            'durationInDays' => 90,
            'price' => 49.99,
        ]);

        MembershipType::create([
            'name' => 'Premium Plan',
            'durationInDays' => 180,
            'price' => 89.99,
        ]);
    }
}
