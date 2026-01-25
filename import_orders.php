<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "===========================================\n";
echo "Robust CSV Import Script for Orders\n";
echo "===========================================\n\n";

DB::table('orders')->truncate();
echo "✓ Table truncated\n";

$csvPath = __DIR__ . '/filtered_products.csv';
$file = fopen($csvPath, 'r');
$header = fgetcsv($file);

$userIds = DB::table('users')->pluck('id')->toArray();
$totalProcessed = 0;
$totalInserted = 0;
$errors = 0;

echo "Starting import...\n";

DB::beginTransaction();

while (($row = fgetcsv($file)) !== false) {
    if (count($row) < 10)
        continue;
    $totalProcessed++;

    try {
        DB::table('orders')->insert([
            'user_id' => $userIds[array_rand($userIds)],
            'product_name' => substr($row[1], 0, 255),
            'category' => substr($row[2], 0, 255),
            'price' => (float) $row[3],
            'city' => substr($row[9], 0, 255),
            'rating' => min((float) $row[5], 5.0),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $totalInserted++;

        if ($totalInserted % 100 == 0) {
            echo "✓ Processed $totalInserted records...\n";
        }
    } catch (\Exception $e) {
        $errors++;
        if ($errors < 5) {
            echo "✗ Error at row $totalProcessed: " . $e->getMessage() . "\n";
        }
    }
}

DB::commit();
fclose($file);

echo "\n===========================================\n";
echo "IMPORT COMPLETED\n";
echo "Total processed: $totalProcessed\n";
echo "Total inserted: $totalInserted\n";
echo "Errors: $errors\n";
echo "===========================================\n";
