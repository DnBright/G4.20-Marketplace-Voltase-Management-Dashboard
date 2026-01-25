<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        $categories = ['Handphone', 'Laptop', 'Aksesoris', 'Audio', 'Kamera'];
        $cities = ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar'];

        // Clear previous data
        Order::truncate();

        // Simulate "Ups and Downs" Trend (Wave Pattern) - Scaled for >1000 Data
        // Aug (Medium), Sep (Low), Oct (High), Nov (Medium), Dec (Peak), Jan (New Year)
        $months = [
            '2025-08' => 150,
            '2025-09' => 80,
            '2025-10' => 280,
            '2025-11' => 190,
            '2025-12' => 450,
            '2026-01' => 120,
        ];

        foreach ($months as $month => $count) {
            for ($i = 0; $i < $count; $i++) {
                $product = $products->random();

                // Create random date within that specific month
                $date = Carbon::parse($month)->addDays(rand(1, 28));

                Order::create([
                    'product_name' => $product->name,
                    'category' => $product->category ?? $categories[array_rand($categories)],
                    'price' => $product->price, // Use real product price
                    'city' => $cities[array_rand($cities)],
                    'rating' => rand(40, 50) / 10,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
