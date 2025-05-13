<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Review;
use App\Models\MembershipType;
use App\Models\Membership;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplement;
use App\Models\GymProduct;
use App\Models\Clothing;
use App\Models\Accessory;
use App\Models\ProductPurchase;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
        UserSeeder::class,
        ReviewSeeder::class,
        MembershipTypeSeeder::class,
        MembershipSeeder::class,
        SupplementSeeder::class,
        GymProductSeeder::class,
        ClothingSeeder::class,
        AccessorySeeder::class,
        ProductPurchaseSeeder::class,
        ]);
    }
}
