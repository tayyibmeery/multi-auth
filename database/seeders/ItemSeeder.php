<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        $items = [
            // Electronics
            [
                'name' => 'Resistor 1k Ohm',
                'code' => 'RES-1K',
                'description' => '1k Ohm 1/4W resistor',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'current_price' => 0.10,
                'current_stock' => 1000,
                'min_stock' => 100,
                'unit' => 'pcs'
            ],
            [
                'name' => 'Capacitor 100uF',
                'code' => 'CAP-100UF',
                'description' => '100uF 25V electrolytic capacitor',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'current_price' => 0.25,
                'current_stock' => 500,
                'min_stock' => 50,
                'unit' => 'pcs'
            ],
            [
                'name' => 'LED Red 5mm',
                'code' => 'LED-RED-5MM',
                'description' => '5mm Red LED',
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'current_price' => 0.15,
                'current_stock' => 2000,
                'min_stock' => 200,
                'unit' => 'pcs'
            ],

            // Electrical
            [
                'name' => 'Wire 22 AWG',
                'code' => 'WIRE-22-AWG',
                'description' => '22 AWG hook-up wire',
                'category_id' => $categories->where('name', 'Electrical')->first()->id,
                'current_price' => 0.05,
                'current_stock' => 5000,
                'min_stock' => 500,
                'unit' => 'meters'
            ],
            [
                'name' => 'PCB Board',
                'code' => 'PCB-SINGLE',
                'description' => 'Single sided PCB board',
                'category_id' => $categories->where('name', 'Electrical')->first()->id,
                'current_price' => 2.50,
                'current_stock' => 100,
                'min_stock' => 20,
                'unit' => 'pcs'
            ],

            // Mechanical
            [
                'name' => 'Screw M3x10',
                'code' => 'SCR-M3-10',
                'description' => 'M3x10mm machine screw',
                'category_id' => $categories->where('name', 'Mechanical')->first()->id,
                'current_price' => 0.02,
                'current_stock' => 10000,
                'min_stock' => 1000,
                'unit' => 'pcs'
            ],
            [
                'name' => 'Nut M3',
                'code' => 'NUT-M3',
                'description' => 'M3 hex nut',
                'category_id' => $categories->where('name', 'Mechanical')->first()->id,
                'current_price' => 0.01,
                'current_stock' => 15000,
                'min_stock' => 1500,
                'unit' => 'pcs'
            ],

            // Plastics
            [
                'name' => 'ABS Filament',
                'code' => 'ABS-1KG',
                'description' => '1KG ABS 3D printing filament',
                'category_id' => $categories->where('name', 'Plastics')->first()->id,
                'current_price' => 25.00,
                'current_stock' => 50,
                'min_stock' => 10,
                'unit' => 'kg'
            ],

            // Metals
            [
                'name' => 'Aluminum Sheet',
                'code' => 'ALU-SHEET-1MM',
                'description' => '1mm thick aluminum sheet',
                'category_id' => $categories->where('name', 'Metals')->first()->id,
                'current_price' => 15.00,
                'current_stock' => 20,
                'min_stock' => 5,
                'unit' => 'sheets'
            ],

            // Packaging
            [
                'name' => 'Cardboard Box Small',
                'code' => 'BOX-SM',
                'description' => 'Small cardboard packaging box',
                'category_id' => $categories->where('name', 'Packaging')->first()->id,
                'current_price' => 0.50,
                'current_stock' => 200,
                'min_stock' => 50,
                'unit' => 'pcs'
            ]
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}