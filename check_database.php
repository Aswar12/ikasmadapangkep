<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== CHECKING DATABASE STRUCTURE ===" . PHP_EOL;

try {
    $columns = Schema::getColumnListing('users');
    echo "Kolom yang ada di tabel users:" . PHP_EOL;
    foreach($columns as $column) {
        echo "- " . $column . PHP_EOL;
    }
    
    echo PHP_EOL . "=== COLUMN CHECKS ===" . PHP_EOL;
    echo "Kolom email ada: " . (Schema::hasColumn('users', 'email') ? 'YES' : 'NO') . PHP_EOL;
    echo "Kolom username ada: " . (Schema::hasColumn('users', 'username') ? 'YES' : 'NO') . PHP_EOL;
    echo "Kolom whatsapp ada: " . (Schema::hasColumn('users', 'whatsapp') ? 'YES' : 'NO') . PHP_EOL;
    echo "Kolom phone ada: " . (Schema::hasColumn('users', 'phone') ? 'YES' : 'NO') . PHP_EOL;
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
