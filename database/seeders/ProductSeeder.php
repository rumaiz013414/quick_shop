<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Sample Product 1',
            'description' => 'Description for Sample Product 1',
            'price' => 29.99,
            'image_url' => 'https://example.com/sample1.jpg',
        ]);

        Product::create([
            'name' => 'Sample Product 2',
            'description' => 'Description for Sample Product 2',
            'price' => 39.99,
            'image_url' => 'https://example.com/sample2.jpg',
        ]);

        // Add more products as needed
    }
}
