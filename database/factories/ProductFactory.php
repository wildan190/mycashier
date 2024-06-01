<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->words(3, true),
            'category_id' => rand(1, 10), // Assuming categories exist in the database
            'price' => 80000,
            'product_stock' => $this->faker->numberBetween(0, 100),
            'status' => 'available',
        ];
    }
}
