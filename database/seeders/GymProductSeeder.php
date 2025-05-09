<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GymProduct;
use \Illuminate\Support\Facades\DB;

class GymProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        try {
            GymProduct::factory()
                ->count(15)
                ->create();
            
            $this->command->info('15 gym products created successfully!');
        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            $this->command->info('Trying fallback creation without productId...');
            
            // Fallback method
            GymProduct::insert([
                'name' => 'Fallback Product',
                'description' => 'Default description',
                'price' => 99.99,
                'category' => 'supplement',
                'stock' => 10,
                // Other required fields
            ]);
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
?>