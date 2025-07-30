<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parts = [
            // Smartphone Parts
            [
                'name' => 'Smartphone Screen Assembly',
                'device_type' => 'Smartphone',
                'issue_category' => 'Screen Replacement',
                'description' => 'Universal smartphone screen replacement part',
                'cost_price' => 15.00,
                'current_stock' => 25,
                'min_stock_level' => 5,
                'location' => 'Shelf A1',
                'compatible_models' => ['iPhone 12', 'iPhone 13', 'Samsung Galaxy S21', 'Samsung Galaxy S22'],
                'notes' => 'Compatible with most modern smartphones'
            ],
            [
                'name' => 'Smartphone Battery',
                'device_type' => 'Smartphone',
                'issue_category' => 'Battery Replacement',
                'description' => 'Universal smartphone battery',
                'cost_price' => 3.00,
                'current_stock' => 50,
                'min_stock_level' => 10,
                'location' => 'Shelf A2',
                'compatible_models' => ['iPhone 11', 'iPhone 12', 'Samsung Galaxy A52'],
                'notes' => 'High quality replacement battery'
            ],
            [
                'name' => 'Charging Port Module',
                'device_type' => 'Smartphone',
                'issue_category' => 'Charging Issue',
                'description' => 'USB-C and Lightning charging port',
                'cost_price' => 5.00,
                'current_stock' => 30,
                'min_stock_level' => 8,
                'location' => 'Shelf A3',
                'compatible_models' => ['iPhone', 'Samsung', 'Xiaomi'],
                'notes' => 'Includes both USB-C and Lightning variants'
            ],
            [
                'name' => 'Camera Module',
                'device_type' => 'Smartphone',
                'issue_category' => 'Camera Malfunction',
                'description' => 'Front and rear camera modules',
                'cost_price' => 4.00,
                'current_stock' => 20,
                'min_stock_level' => 5,
                'location' => 'Shelf A4',
                'compatible_models' => ['iPhone 12', 'Samsung Galaxy'],
                'notes' => 'High resolution camera replacement'
            ],
            [
                'name' => 'Speaker/Microphone Assembly',
                'device_type' => 'Smartphone',
                'issue_category' => 'Speaker/Microphone Issue',
                'description' => 'Audio components for smartphones',
                'cost_price' => 6.00,
                'current_stock' => 15,
                'min_stock_level' => 3,
                'location' => 'Shelf A5',
                'compatible_models' => ['Universal'],
                'notes' => 'Works with most smartphone models'
            ],

            // Tablet Parts
            [
                'name' => 'Tablet Screen Assembly',
                'device_type' => 'Tablet',
                'issue_category' => 'Screen Replacement',
                'description' => 'Large tablet screen replacement',
                'cost_price' => 30.00,
                'current_stock' => 15,
                'min_stock_level' => 3,
                'location' => 'Shelf B1',
                'compatible_models' => ['iPad Air', 'iPad Pro', 'Samsung Galaxy Tab'],
                'notes' => 'Includes digitizer and LCD'
            ],
            [
                'name' => 'Tablet Battery',
                'device_type' => 'Tablet',
                'issue_category' => 'Battery Replacement',
                'description' => 'High capacity tablet battery',
                'cost_price' => 20.00,
                'current_stock' => 12,
                'min_stock_level' => 2,
                'location' => 'Shelf B2',
                'compatible_models' => ['iPad', 'Samsung Tab'],
                'notes' => 'Long lasting battery replacement'
            ],
            [
                'name' => 'Tablet Charging Port',
                'device_type' => 'Tablet',
                'issue_category' => 'Charging Issue',
                'description' => 'Tablet charging port module',
                'cost_price' => 12.00,
                'current_stock' => 8,
                'min_stock_level' => 2,
                'location' => 'Shelf B3',
                'compatible_models' => ['iPad', 'Android Tablets'],
                'notes' => 'USB-C and Lightning variants available'
            ],

            // Laptop Parts
            [
                'name' => 'Laptop Screen Panel',
                'device_type' => 'Laptop',
                'issue_category' => 'Screen Replacement',
                'description' => 'LCD screen panel for laptops',
                'cost_price' => 45.00,
                'current_stock' => 8,
                'min_stock_level' => 2,
                'location' => 'Shelf C1',
                'compatible_models' => ['MacBook Air', 'MacBook Pro', 'Dell', 'HP'],
                'notes' => 'Various sizes: 13", 15", 16"'
            ],
            [
                'name' => 'Laptop Battery',
                'device_type' => 'Laptop',
                'issue_category' => 'Battery Replacement',
                'description' => 'Laptop replacement battery',
                'cost_price' => 35.00,
                'current_stock' => 10,
                'min_stock_level' => 2,
                'location' => 'Shelf C2',
                'compatible_models' => ['MacBook', 'Dell', 'HP', 'Lenovo'],
                'notes' => 'High quality Li-ion battery'
            ],
            [
                'name' => 'Laptop Keyboard',
                'device_type' => 'Laptop',
                'issue_category' => 'Keyboard Malfunction',
                'description' => 'Replacement keyboard assembly',
                'cost_price' => 25.00,
                'current_stock' => 6,
                'min_stock_level' => 2,
                'location' => 'Shelf C3',
                'compatible_models' => ['MacBook', 'Dell', 'HP'],
                'notes' => 'Multiple layouts available'
            ],

            // Desktop Parts
            [
                'name' => 'Power Supply Unit',
                'device_type' => 'Desktop PC',
                'issue_category' => 'Power Supply Failure',
                'description' => 'ATX power supply unit',
                'cost_price' => 40.00,
                'current_stock' => 5,
                'min_stock_level' => 1,
                'location' => 'Shelf D1',
                'compatible_models' => ['Universal ATX'],
                'notes' => '500W-750W variants available'
            ],
            [
                'name' => 'Cooling Fan',
                'device_type' => 'Desktop PC',
                'issue_category' => 'Overheating',
                'description' => 'CPU and case cooling fans',
                'cost_price' => 15.00,
                'current_stock' => 12,
                'min_stock_level' => 3,
                'location' => 'Shelf D2',
                'compatible_models' => ['Universal'],
                'notes' => 'Various sizes: 80mm, 120mm, 140mm'
            ],

            // Smartwatch Parts
            [
                'name' => 'Smartwatch Screen',
                'device_type' => 'Smartwatch',
                'issue_category' => 'Screen Replacement',
                'description' => 'Small OLED display for smartwatch',
                'cost_price' => 25.00,
                'current_stock' => 4,
                'min_stock_level' => 1,
                'location' => 'Shelf E1',
                'compatible_models' => ['Apple Watch', 'Samsung Galaxy Watch'],
                'notes' => 'OLED technology, touch sensitive'
            ],
            [
                'name' => 'Smartwatch Battery',
                'device_type' => 'Smartwatch',
                'issue_category' => 'Battery Replacement',
                'description' => 'Compact smartwatch battery',
                'cost_price' => 18.00,
                'current_stock' => 6,
                'min_stock_level' => 1,
                'location' => 'Shelf E2',
                'compatible_models' => ['Apple Watch', 'Samsung Watch'],
                'notes' => 'Long-lasting Li-ion battery'
            ]
        ];

        foreach ($parts as $part) {
            \App\Models\Part::create($part);
        }
    }
}
