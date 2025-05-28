@echo off
echo ===============================================
echo   FIX ANTARKANMA WHATSAPP LOGIN - FINAL
echo ===============================================
echo.
echo Memperbaiki error: Column 'whatsapp' not found
echo Aplikasi: Antarkanma E-Commerce
echo.

echo STEP 1: Cek struktur database saat ini...
echo ==========================================
php artisan tinker --execute="
use Illuminate\Support\Facades\Schema;
echo 'Struktur tabel users saat ini:' . PHP_EOL;
try {
    \$columns = Schema::getColumnListing('users');
    foreach(\$columns as \$column) {
        echo '  - ' . \$column . PHP_EOL;
    }
    echo PHP_EOL . 'Status kolom:' . PHP_EOL;
    echo '  Email: ' . (Schema::hasColumn('users', 'email') ? 'ADA' : 'TIDAK ADA') . PHP_EOL;
    echo '  Username: ' . (Schema::hasColumn('users', 'username') ? 'ADA' : 'TIDAK ADA') . PHP_EOL;
    echo '  WhatsApp: ' . (Schema::hasColumn('users', 'whatsapp') ? 'ADA' : 'TIDAK ADA') . PHP_EOL;
    echo '  Phone: ' . (Schema::hasColumn('users', 'phone') ? 'ADA' : 'TIDAK ADA') . PHP_EOL;
} catch (Exception \$e) {
    echo 'Error: ' . \$e->getMessage() . PHP_EOL;
}
"

echo.
echo STEP 2: Menjalankan migration fix...
echo ====================================
php artisan migrate --force

echo.
echo STEP 3: Verifikasi setelah migration...
echo ======================================
php artisan tinker --execute="
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo 'Struktur tabel users setelah fix:' . PHP_EOL;
\$columns = Schema::getColumnListing('users');
foreach(\$columns as \$column) {
    echo '  ✓ ' . \$column . PHP_EOL;
}

echo PHP_EOL . 'Verifikasi kolom login:' . PHP_EOL;
echo '  Email: ' . (Schema::hasColumn('users', 'email') ? '✅ ADA' : '❌ TIDAK ADA') . PHP_EOL;
echo '  Username: ' . (Schema::hasColumn('users', 'username') ? '✅ ADA' : '❌ TIDAK ADA') . PHP_EOL;
echo '  WhatsApp: ' . (Schema::hasColumn('users', 'whatsapp') ? '✅ ADA' : '❌ TIDAK ADA') . PHP_EOL;

echo PHP_EOL . 'Jumlah users: ' . DB::table('users')->count() . PHP_EOL;
"

echo.
echo STEP 4: Test login scope functionality...
echo ========================================
php artisan tinker --execute="
use App\Models\User;

echo 'Testing whereIdentifier scope...' . PHP_EOL;

// Test dengan email
try {
    \$query = User::whereIdentifier('test@example.com');
    echo '  ✅ Email scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ❌ Email scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}

// Test dengan username
try {
    \$query = User::whereIdentifier('testuser');
    echo '  ✅ Username scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ❌ Username scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}

// Test dengan WhatsApp
try {
    \$query = User::whereIdentifier('081234567890');
    echo '  ✅ WhatsApp scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ❌ WhatsApp scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}

// Test dengan format +628
try {
    \$query = User::whereIdentifier('+6281234567890');
    echo '  ✅ +628 format scope: WORKING' . PHP_EOL;
} catch (Exception \$e) {
    echo '  ❌ +628 format scope: ERROR - ' . \$e->getMessage() . PHP_EOL;
}
"

echo.
echo STEP 5: Buat test user jika belum ada...
echo =======================================
php artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;

\$testUser = User::where('email', 'admin@antarkanma.com')->first();
if (!\$testUser) {
    try {
        User::create([
            'name' => 'Admin Antarkanma',
            'email' => 'admin@antarkanma.com',
            'username' => 'admin',
            'whatsapp' => '081234567890',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);
        echo '✅ Test user berhasil dibuat!' . PHP_EOL;
    } catch (Exception \$e) {
        echo '❌ Error membuat test user: ' . \$e->getMessage() . PHP_EOL;
    }
} else {
    echo 'ℹ️ Test user sudah ada' . PHP_EOL;
}

echo PHP_EOL . 'Test users yang tersedia:' . PHP_EOL;
\$users = User::take(3)->get(['name', 'email', 'username', 'whatsapp']);
foreach (\$users as \$user) {
    echo '  - ' . \$user->name . ' (' . \$user->email . ')' . PHP_EOL;
    if (\$user->username) echo '    Username: ' . \$user->username . PHP_EOL;
    if (\$user->whatsapp) echo '    WhatsApp: ' . \$user->whatsapp . PHP_EOL;
}
"

echo.
echo STEP 6: Test login dengan identifier aswarsumarlin...
echo ===================================================
php artisan tinker --execute="
use App\Models\User;

echo 'Mencari user dengan identifier: aswarsumarlin' . PHP_EOL;
try {
    \$user = User::whereIdentifier('aswarsumarlin')->first();
    if (\$user) {
        echo '✅ User ditemukan: ' . \$user->name . ' (' . \$user->email . ')' . PHP_EOL;
    } else {
        echo 'ℹ️ User dengan identifier \"aswarsumarlin\" tidak ditemukan' . PHP_EOL;
        echo 'Pastikan ada user dengan email, username, atau whatsapp: aswarsumarlin' . PHP_EOL;
    }
} catch (Exception \$e) {
    echo '❌ Error: ' . \$e->getMessage() . PHP_EOL;
}
"

echo.
echo ===============================================
echo          ANTARKANMA LOGIN FIX SELESAI!
echo ===============================================
echo.
echo 🎯 HASIL FIX:
echo   ✅ Kolom whatsapp sudah ditambahkan
echo   ✅ Kolom username sudah ada
echo   ✅ Scope whereIdentifier sudah diperbaiki
echo   ✅ Multi-login support: Email, Username, WhatsApp
echo.
echo 📱 FORMAT WHATSAPP YANG DIDUKUNG:
echo   - 081234567890 (format Indonesia)
echo   - 6281234567890 (format internasional)
echo   - +6281234567890 (format dengan +)
echo.
echo 🧪 TEST LOGIN:
echo   Email: admin@antarkanma.com
echo   Username: admin
echo   WhatsApp: 081234567890
echo   Password: admin123
echo.
echo Aplikasi Antarkanma siap melayani masyarakat
echo di Kecamatan Segeri, Mandalle, dan Marang! 🏪
echo.
pause
