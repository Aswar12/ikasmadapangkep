<?php
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Current time: " . date('Y-m-d H:i:s') . "\n";
echo "Test file works!\n";

// Test autoload
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "Vendor autoload exists\n";
    require_once __DIR__ . '/vendor/autoload.php';
    echo "Autoload loaded successfully\n";
} else {
    echo "Vendor autoload NOT found\n";
}

// Test Laravel bootstrap
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "Laravel app bootstrap successful\n";
} catch (Exception $e) {
    echo "Laravel bootstrap error: " . $e->getMessage() . "\n";
}
