<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accessory;

class AccessorySeeder extends Seeder
{
    public function run(): void
    {
        Accessory::create([
            'productId' => 7, // Yoga Mat
            'material' => 'Foam',
            'brand' => 'Gaiam',
            'size' => 'Standard',
            'weight' => 1.0,
        ]);

        Accessory::create([
            'productId' => 8, // Gym Bag
            'material' => 'Nylon',
            'brand' => 'Nike',
            'size' => 'Large',
            'weight' => 0.8,
        ]);

        Accessory::create([
            'productId' => 9, // Resistance Bands
            'material' => 'Rubber',
            'brand' => 'Fit Simplify',
            'size' => 'Set',
            'weight' => 0.6,
        ]);
    }
}
