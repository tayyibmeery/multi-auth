<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic components and devices'],
            ['name' => 'Mechanical', 'description' => 'Mechanical parts and tools'],
            ['name' => 'Electrical', 'description' => 'Electrical components and wiring'],
            ['name' => 'Plastics', 'description' => 'Plastic materials and components'],
            ['name' => 'Metals', 'description' => 'Metal parts and raw materials'],
            ['name' => 'Packaging', 'description' => 'Packaging materials'],
            ['name' => 'Consumables', 'description' => 'Consumable items and supplies'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}