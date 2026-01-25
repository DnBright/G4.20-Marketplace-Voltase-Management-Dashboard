<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCsvSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = base_path('filtered_products.csv');
        if (!file_exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header row

        $batchSize = 100;
        $data = [];

        // Truncate to avoid duplicates if running multiple times (User might prefer this)
        DB::table('products')->truncate();

        while (($row = fgetcsv($file)) !== false) {
            // Map ROW based on CSV Header positions:
            // 0:id, 1:name, 2:product_category, 3:price, 5:rating, 9:shop_city

            // Safety check for row length
            if (count($row) < 10)
                continue;

            $data[] = [
                'name' => substr($row[1], 0, 100),
                'category' => $row[2],
                'price' => (float) $row[3],
                'rating' => (float) $row[5],
                'city' => $row[9],
                'image' => 'https://placehold.co/400x300/1c1c1c/75B06F?text=Product',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($data) >= $batchSize) {
                DB::table('products')->insert($data);
                $data = [];
            }
        }

        // Insert remaining
        if (!empty($data)) {
            DB::table('products')->insert($data);
        }

        fclose($file);
    }
}
