<?php
// Simulate the vulnerable function
function download_file_vulnerable($product_file) {
    $filename = getcwd() . '/public/storage/product/' . $product_file;
    echo "Vulnerable path: " . $filename . "\n";
    if (file_exists($filename)) {
        return "File content of " . $product_file;
    } else {
        return "File not found.";
    }
}

// Simulate the fixed function
function download_file_fixed($product_file) {
    $filename = getcwd() . '/public/storage/product/' . basename($product_file);
    echo "Fixed path: " . $filename . "\n";
    if (file_exists($filename)) {
        return "File content of " . basename($product_file);
    } else {
        return "File not found.";
    }
}

// Test cases
$valid_file = 'test.txt';
$traversal_attack = '../../../../../../../etc/passwd';

// Create a dummy file for testing
mkdir(getcwd() . '/public/storage/product', 0777, true);
file_put_contents(getcwd() . '/public/storage/product/test.txt', 'This is a test file.');

echo "Testing vulnerable function:\n";
echo download_file_vulnerable($valid_file) . "\n";
echo download_file_vulnerable($traversal_attack) . "\n\n";

echo "Testing fixed function:\n";
echo download_file_fixed($valid_file) . "\n";
echo download_file_fixed($traversal_attack) . "\n";
