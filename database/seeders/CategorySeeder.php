<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Technology',
            'description' => 'All about technology'
        ]);

        Category::create([
            'name' => 'Health',
            'description' => 'Health and wellness tips'
        ]);

        Category::create([
            'name' => 'Education',
            'description' => 'Educational resources and articles'
        ]);
    }
}
