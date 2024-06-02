<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $categories = [
            'Soft Drink',
            'Water Bottle',
            'Snack',
            'Makanan',
            'Hair Care',
            'Body Care',
            'Skin Care',
            'Grooming Tools Wanita',
            'Grooming Tools Pria',
        ];
        return [
            'name' => $this->faker->randomElement($categories),
            'description' => $this->faker->sentence,
        ];
    }
}
