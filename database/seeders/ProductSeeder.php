<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'USB Charger',
                'code' => 'USB-CHG-01',
                'description' => '5V 2A USB Wall Charger',
                'selling_price' => 12.99,
                'current_stock' => 50
            ],
            [
                'name' => 'LED Desk Lamp',
                'code' => 'LED-LAMP-01',
                'description' => 'Adjustable LED Desk Lamp',
                'selling_price' => 29.99,
                'current_stock' => 25
            ],
            [
                'name' => 'Power Bank 10000mAh',
                'code' => 'PWR-BANK-10K',
                'description' => '10000mAh Portable Power Bank',
                'selling_price' => 24.99,
                'current_stock' => 30
            ],
            [
                'name' => 'Bluetooth Speaker',
                'code' => 'BT-SPK-01',
                'description' => 'Portable Bluetooth Speaker',
                'selling_price' => 39.99,
                'current_stock' => 15
            ],
            [
                'name' => 'Phone Stand',
                'code' => 'PHN-STAND-01',
                'description' => 'Adjustable Aluminum Phone Stand',
                'selling_price' => 8.99,
                'current_stock' => 100
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}