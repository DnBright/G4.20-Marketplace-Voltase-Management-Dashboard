<?php
$f = fopen('filtered_products.csv', 'r');
if (!$f)
    die("Could not open file\n");
$h = fgetcsv($f);
$r = fgetcsv($f);
echo "Header count: " . count($h) . "\n";
echo "Row 1 count: " . count($r) . "\n";
echo "Header:\n";
print_r($h);
echo "Row 1:\n";
print_r($r);
fclose($f);
