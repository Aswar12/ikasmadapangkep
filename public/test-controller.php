<?php
echo "Test time: " . date('Y-m-d H:i:s') . "\n";
echo "PaymentController exists: " . (file_exists(__DIR__ . '/app/Http/Controllers/Alumni/PaymentController.php') ? 'YES' : 'NO') . "\n";

// Test if we can read the current PaymentController
$content = file_get_contents(__DIR__ . '/app/Http/Controllers/Alumni/PaymentController.php');
echo "File size: " . strlen($content) . " bytes\n";
echo "Contains TesseractOCR: " . (strpos($content, 'TesseractOCR') !== false ? 'YES' : 'NO') . "\n";
echo "Contains Payment model import: " . (strpos($content, 'use App\Models\Payment;') !== false ? 'YES' : 'NO') . "\n";
echo "Test completed successfully!\n";
