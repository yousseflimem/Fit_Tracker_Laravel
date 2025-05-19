<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GymProduct;

class GymProductSeeder extends Seeder
{
    public function run(): void
    {
        // 🧥 CLOTHING PRODUCTS
        GymProduct::create([
            'name' => 'Running Shoes',
            'description' => 'Comfortable and durable shoes for long-distance running.',
            'price' => 69.99,
            'category' => 'Clothing',
            'stock' => 30,
            'imgURL' => 'https://example.com/images/running_shoes.jpg',
            
        ]);

        GymProduct::create([
            'name' => 'Compression Shirt',
            'description' => 'A breathable shirt that supports muscle recovery.',
            'price' => 49.99,
            'category' => 'Clothing',
            'stock' => 60,
            'imgURL' => 'https://example.com/images/compression_shirt.jpg',
        ]);

        GymProduct::create([
            'name' => 'Jogging Pants',
            'description' => 'Stretchy jogging pants suitable for workouts or casual wear.',
            'price' => 39.99,
            'category' => 'Clothing',
            'stock' => 40,
            'imgURL' => 'https://example.com/images/jogging_pants.jpg',
        ]);

        // 🧪 SUPPLEMENT PRODUCTS
        GymProduct::create([
            'name' => 'Whey Protein',
            'description' => 'A fast-absorbing protein powder for muscle gain.',
            'price' => 34.99,
            'category' => 'Supplement',
            'stock' => 100,
            'imgURL' => 'https://example.com/images/whey_protein.jpg',
        ]);

        GymProduct::create([
            'name' => 'Creatine Monohydrate',
            'description' => 'Supports increased strength and high-intensity performance.',
            'price' => 24.99,
            'category' => 'Supplement',
            'stock' => 80,
            'imgURL' => 'https://example.com/images/creatine.jpg',
        ]);

        GymProduct::create([
            'name' => 'BCAA Capsules',
            'description' => 'Branched-chain amino acids to reduce fatigue and boost recovery.',
            'price' => 19.99,
            'category' => 'Supplement',
            'stock' => 120,
            'imgURL' => 'https://example.com/images/bcaa.jpg',
        ]);

        // 🧳 ACCESSORY PRODUCTS
        GymProduct::create([
            'name' => 'Yoga Mat',
            'description' => 'Non-slip mat for yoga, stretching, and floor exercises.',
            'price' => 19.99,
            'category' => 'Accessory',
            'stock' => 50,
            'imgURL' => 'https://example.com/images/yoga_mat.jpg',
        ]);

        GymProduct::create([
            'name' => 'Gym Bag',
            'description' => 'Spacious and stylish bag for carrying gym essentials.',
            'price' => 24.99,
            'category' => 'Accessory',
            'stock' => 100,
            'imgURL' => 'https://example.com/images/gym_bag.jpg',
        ]);

        GymProduct::create([
            'name' => 'Resistance Bands',
            'description' => 'Set of resistance bands for strength and mobility training.',
            'price' => 15.99,
            'category' => 'Accessory',
            'stock' => 80,
            'imgURL' => 'https://example.com/images/resistance_bands.jpg',
        ]);
    }
}
