<?php

namespace Database\Factories;

use App\Models\Category;
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
        $productNames = [
            'Coca-Cola',
            'San Pellegrino',
            'Waterbottle',
            'Snack Chips',
            'Snack Cheese',
            'Snack Cookies',
            'Snack Sausage',
            'Snack Chicken',
            'Snack Watermelon',
            'Snack Mango',
            'Snack Pineapple',
            'Snack Strawberry',
            'Snack Fruit Juice',
            'Snack Yogurt',
            'Snack Energy Bottle',
            'Shampoo',
            'Conditioner',
            'Body Wash',
            'Razor',
            'Conditioner Wanita',
            'Conditioner Pria'
        ];
        $categories = Category::pluck('id')->toArray();
        return [
            'product_name' => $this->faker->randomElement($productNames),
            'category_id' => $this->faker->randomElement($categories),
            'price' => $this->faker->randomDigitNotNull,
            'product_stock' => $this->faker->numberBetween(0, 100),
            'status' => 'available',
        ];
    }
}

