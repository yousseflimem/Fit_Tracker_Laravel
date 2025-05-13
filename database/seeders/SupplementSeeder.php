<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplement;

class SupplementSeeder extends Seeder
{
    public function run(): void
    {
        Supplement::create([
            'productId' => 4, // Whey Protein
            'flavor' => 'Vanilla',
            'weight' => 1000,
            'form' => 'Powder',
        ]);

        Supplement::create([
            'productId' => 5, // Creatine Monohydrate
            'flavor' => 'Unflavored',
            'weight' => 300,
            'form' => 'Powder',
        ]);

        Supplement::create([
            'productId' => 6, // BCAA Capsules
            'flavor' => 'Berry',
            'weight' => 250,
            'form' => 'Capsule',
        ]);
    }
}
