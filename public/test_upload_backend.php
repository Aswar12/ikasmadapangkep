<?php
// Test Upload Backend Debug Script

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Setup debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get logged in user
$user = Auth::user();

if (!$user) {
    die('User not logged in. Please login first at /login');
}

echo "<h2>Upload Photo Debug Tool</h2>";
echo "<p>User: " . $user->name . " (ID: " . $user->id . ")</p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
    echo "<h3>Debug Information:</h3>";
    echo "<pre>";
    
    // Check $_FILES
    echo "1. \$_FILES content:\n";
    print_r($_FILES);
    
    // Check file upload errors
    $uploadError = $_FILES['profile_photo']['error'] ?? UPLOAD_ERR_NO_FILE;
    echo "\n2. Upload Error Code: $uploadError\n";
    
    $errorMessages = [
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
    ];
    
    echo "   Error Message: " . ($errorMessages[$uploadError] ?? 'Unknown error') . "\n";
    
    // Check temporary file
    $tmpName = $_FILES['profile_photo']['tmp_name'] ?? '';
    echo "\n3. Temporary file path: '$tmpName'\n";
    echo "   File exists: " . (file_exists($tmpName) ? 'YES' : 'NO') . "\n";
    echo "   File size: " . (file_exists($tmpName) ? filesize($tmpName) . ' bytes' : 'N/A') . "\n";
    echo "   Is uploaded file: " . (is_uploaded_file($tmpName) ? 'YES' : 'NO') . "\n";
    
    // Check PHP configuration
    echo "\n4. PHP Configuration:\n";
    echo "   post_max_size: " . ini_get('post_max_size') . "\n";
    echo "   upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
    echo "   file_uploads: " . (ini_get('file_uploads') ? 'ON' : 'OFF') . "\n";
    echo "   upload_tmp_dir: " . ini_get('upload_tmp_dir') . "\n";
    echo "   sys_temp_dir: " . sys_get_temp_dir() . "\n";
    
    // Check Laravel Request
    echo "\n5. Laravel Request:\n";
    $request = request();
    echo "   Has file 'profile_photo': " . ($request->hasFile('profile_photo') ? 'YES' : 'NO') . "\n";
    
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        echo "   File valid: " . ($file->isValid() ? 'YES' : 'NO') . "\n";
        echo "   Original name: " . $file->getClientOriginalName() . "\n";
        echo "   MIME type: " . $file->getClientMimeType() . "\n";
        echo "   Size: " . $file->getSize() . " bytes\n";
        echo "   Real path: " . $file->getRealPath() . "\n";
        echo "   Path name: " . $file->getPathname() . "\n";
        
        // Try to get error if any
        if (!$file->isValid()) {
            echo "   Error: " . $file->getError() . "\n";
            echo "   Error message: " . $file->getErrorMessage() . "\n";
        }
    }
    
    // Check storage directories
    echo "\n6. Storage Directories:\n";
    $publicPath = storage_path('app/public');
    echo "   Storage public path: $publicPath\n";
    echo "   Exists: " . (is_dir($publicPath) ? 'YES' : 'NO') . "\n";
    echo "   Writable: " . (is_writable($publicPath) ? 'YES' : 'NO') . "\n";
    
    $profilePhotosPath = storage_path('app/public/profile-photos');
    echo "   Profile photos path: $profilePhotosPath\n";
    echo "   Exists: " . (is_dir($profilePhotosPath) ? 'YES' : 'NO') . "\n";
    echo "   Writable: " . (is_dir($profilePhotosPath) && is_writable($profilePhotosPath) ? 'YES' : 'NO') . "\n";
    
    echo "</pre>";
    
    // Try the actual upload
    if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
        echo "<h3>Attempting actual upload...</h3>";
        try {
            $file = $request->file('profile_photo');
            
            // Method 1: Using Jetstream trait
            echo "<p>Method 1: Using Jetstream's updateProfilePhoto...</p>";
            try {
                $user->updateProfilePhoto($file);
                echo "<p style='color: green;'>✓ Success with Jetstream method!</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Jetstream method failed: " . $e->getMessage() . "</p>";
                echo "<pre>" . $e->getTraceAsString() . "</pre>";
            }
            
            // Method 2: Manual upload
            echo "<p>Method 2: Manual file upload...</p>";
            try {
                $filename = 'test_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile-photos', $filename, 'public');
                echo "<p style='color: green;'>✓ Manual upload successful! Path: $path</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Manual upload failed: " . $e->getMessage() . "</p>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
        }
    }
} else {
    // Show upload form
    ?>
    <form method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <p>
            <label>Select Photo:</label><br>
            <input type="file" name="profile_photo" accept="image/*" required>
        </p>
        <p>
            <button type="submit">Test Upload</button>
        </p>
    </form>
    <?php
}
?>
