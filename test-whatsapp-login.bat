@echo off
echo ===========================================
echo   TEST WHATSAPP LOGIN FUNCTIONALITY
echo ===========================================
echo.

echo 1. Running WhatsApp Login Tests...
echo.
php artisan test tests/Feature/WhatsAppLoginTest.php --verbose

echo.
echo 2. Manual verification of database structure...
echo.
php artisan tinker --execute="
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

echo '=== DATABASE STRUCTURE VERIFICATION ===' . PHP_EOL;
echo 'Kolom yang ada di tabel users:' . PHP_EOL;
\$columns = Schema::getColumnListing('users');
foreach(\$columns as \$column) {
    echo '  ✓ ' . \$column . PHP_EOL;
}

echo PHP_EOL . '=== COLUMN CHECKS ===' . PHP_EOL;
echo 'Kolom whatsapp ada: ' . (Schema::hasColumn('users', 'whatsapp') ? '✓ YES' : '✗ NO') . PHP_EOL;
echo 'Kolom username ada: ' . (Schema::hasColumn('users', 'username') ? '✓ YES' : '✗ NO') . PHP_EOL;
echo 'Kolom email ada: ' . (Schema::hasColumn('users', 'email') ? '✓ YES' : '✗ NO') . PHP_EOL;

echo PHP_EOL . '=== DATA VERIFICATION ===' . PHP_EOL;
echo 'Total users dalam database: ' . DB::table('users')->count() . PHP_EOL;

echo PHP_EOL . '=== LOGIN SCOPE TESTING ===' . PHP_EOL;
echo 'Testing whereIdentifier scope dengan berbagai format...' . PHP_EOL;

// Test dengan email
try {
    \$user = User::whereIdentifier('test@example.com')->first();
    echo '  ✓ Email login scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ✗ Email login scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}

// Test dengan username
try {
    \$user = User::whereIdentifier('testuser')->first();
    echo '  ✓ Username login scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ✗ Username login scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}

// Test dengan WhatsApp
try {
    \$user = User::whereIdentifier('081234567890')->first();
    echo '  ✓ WhatsApp login scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ✗ WhatsApp login scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}

echo PHP_EOL . '=== MODEL FEATURES TESTING ===' . PHP_EOL;
\$testUser = User::first();
if (\$testUser) {
    echo 'Testing User model methods dengan user: ' . \$testUser->name . PHP_EOL;
    echo '  ✓ Display identifier: ' . \$testUser->display_identifier . PHP_EOL;
    echo '  ✓ WhatsApp formatted: ' . (\$testUser->whatsapp_formatted ?? 'N/A') . PHP_EOL;
    echo '  ✓ Account locked: ' . (\$testUser->isAccountLocked() ? 'YES' : 'NO') . PHP_EOL;
} else {
    echo '  ℹ No users found. Run seeder: php artisan db:seed --class=UserSeeder' . PHP_EOL;
}
"

echo.
echo 3. Creating test users if not exist...
echo.
php artisan db:seed --class=UserSeeder

echo.
echo ===========================================
echo WhatsApp Login Test completed!
echo ===========================================
echo.
echo You can now test login manually:
echo - Email: admin@example.com, Password: password
echo - Username: admin, Password: password  
echo - WhatsApp: 081234567890, Password: password
echo.
pause
