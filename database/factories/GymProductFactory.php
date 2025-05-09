<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\GymProduct;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GymProduct>
 */
class GymProductFactory extends Factory
{
    
    protected $model = GymProduct::class;

    public function definition(): array
    {
        $hasProductId = \Schema::hasColumn('gym_products', 'productId');

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 500),
            'category' => $this->faker->randomElement(['supplement', 'clothing', 'accessory']),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
?>
