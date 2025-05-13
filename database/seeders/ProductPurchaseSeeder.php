<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPurchase;
use Carbon\Carbon;

class ProductPurchaseSeeder extends Seeder
{
    public function run(): void
    {
        ProductPurchase::create([
            'user_id' => 1,  // Assuming User ID 1 exists
            'product_id' => 1,  // Assuming GymProduct ID 1 exists
            'quantity' => 2,
            'price_at_purchase' => 29.99,
            'purchase_date' => Carbon::now(),
        ]);

        ProductPurchase::create([
            'user_id' => 2,  // Assuming User ID 2 exists
            'product_id' => 2,  // Assuming GymProduct ID 2 exists
            'quantity' => 1,
            'price_at_purchase' => 49.99,
            'purchase_date' => Carbon::now()->subDays(5),
        ]);

        ProductPurchase::create([
            'user_id' => 3,  // Assuming User ID 3 exists
            'product_id' => 3,  // Assuming GymProduct ID 3 exists
            'quantity' => 3,
            'price_at_purchase' => 19.99,
            'purchase_date' => Carbon::now()->subDays(10),
        ]);
    }
}
