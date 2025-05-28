#!/bin/bash
echo "==========================================="
echo "   FIX WHATSAPP LOGIN COLUMN ISSUE"
echo "==========================================="
echo

echo "1. Menjalankan migration untuk memperbaiki kolom whatsapp..."
php artisan migrate --force

echo
echo "2. Checking database structure..."
php artisan tinker --execute="
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo 'Kolom yang ada di tabel users:' . PHP_EOL;
\$columns = Schema::getColumnListing('users');
foreach(\$columns as \$column) {
    echo '- ' . \$column . PHP_EOL;
}

echo PHP_EOL . 'Cek apakah kolom whatsapp ada: ';
echo Schema::hasColumn('users', 'whatsapp') ? 'YES' : 'NO';
echo PHP_EOL;

echo 'Cek apakah kolom username ada: ';
echo Schema::hasColumn('users', 'username') ? 'YES' : 'NO';
echo PHP_EOL;

echo 'Total users: ' . DB::table('users')->count() . PHP_EOL;
"

echo
echo "3. Testing login query..."
php artisan tinker --execute="
use App\Models\User;

echo 'Testing whereIdentifier scope...' . PHP_EOL;
try {
    \$testUser = User::whereIdentifier('test@example.com')->first();
    echo 'whereIdentifier scope berfungsi dengan baik!' . PHP_EOL;
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage() . PHP_EOL;
}
"

echo
echo "==========================================="
echo "Fix WhatsApp login column completed!"
echo "==========================================="
