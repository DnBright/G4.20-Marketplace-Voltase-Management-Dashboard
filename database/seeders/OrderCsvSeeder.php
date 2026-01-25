<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderCsvSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $csvPath = base_path('filtered_products.csv');
        if (!file_exists($csvPath)) {
            $this->command->error("CSV file not found at: $csvPath");
            return;
        }

        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header row

        $totalProcessed = 0;
        $totalInserted = 0;

        $this->command->info('Connection: ' . DB::getDefaultConnection());
        $this->command->info('Database: ' . DB::connection()->getDatabaseName());

        DB::table('orders')->truncate();
        $this->command->info('Starting CSV import to orders table...');

        while (($row = fgetcsv($file)) !== false) {
            $totalProcessed++;

            if (count($row) < 10)
                continue;

            $insertData = [
                'product_name' => substr($row[1], 0, 255),
                'category' => substr($row[2], 0, 255),
                'price' => (float) $row[3],
                'city' => substr($row[9], 0, 255),
                'rating' => min((float) $row[5], 5.0),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            try {
                DB::table('orders')->insert($insertData);
                $totalInserted++;
            } catch (\Exception $e) {
                $this->command->error("Row $totalProcessed failed: " . $e->getMessage());
                // For row-by-row, we can decide to stop or continue. 
                // Let's continue but report.
            }

            if ($totalInserted % 100 == 0) {
                $this->command->info("✓ Inserted: $totalInserted rows...");
            }
        }

        fclose($file);

        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("✓ Import completed!");
        $this->command->info("📊 Total rows: $totalProcessed");
        $this->command->info("✅ Total success: $totalInserted");
        $this->command->info("🔍 Final count: " . DB::table('orders')->count());
    }
}
