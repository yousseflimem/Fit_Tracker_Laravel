<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clothing;

class ClothingSeeder extends Seeder
{
    public function run(): void
    {
        Clothing::create([
            'productId' => 1, // Running Shoes
            'size' => 'M',
            'color' => 'Black',
            'gender' => 'Unisex',
            'material' => 'Mesh',
        ]);

        Clothing::create([
            'productId' => 2, // Compression Shirt
            'size' => 'L',
            'color' => 'Gray',
            'gender' => 'Men',
            'material' => 'Polyester',
        ]);

        Clothing::create([
            'productId' => 3, // Jogging Pants
            'size' => 'S',
            'color' => 'Navy Blue',
            'gender' => 'Women',
            'material' => 'Cotton',
        ]);
    }
}
