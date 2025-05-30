<?php
// Check PHP configuration for file uploads

echo "<h2>PHP Upload Configuration Check</h2>";
echo "<pre>";

// Basic info
echo "PHP Version: " . phpversion() . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n\n";

// File upload settings
echo "=== File Upload Settings ===\n";
echo "file_uploads: " . (ini_get('file_uploads') ? 'ON' : 'OFF') . "\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_file_uploads: " . ini_get('max_file_uploads') . "\n";
echo "max_input_time: " . ini_get('max_input_time') . " seconds\n";
echo "max_execution_time: " . ini_get('max_execution_time') . " seconds\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n\n";

// Temporary directory
echo "=== Temporary Directory ===\n";
echo "upload_tmp_dir: " . (ini_get('upload_tmp_dir') ?: '(default system temp)') . "\n";
echo "sys_temp_dir: " . sys_get_temp_dir() . "\n";

// Check if temp dir is writable
$tempDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();
echo "Temp dir writable: " . (is_writable($tempDir) ? 'YES' : 'NO') . "\n\n";

// Laravel specific paths
echo "=== Laravel Storage Paths ===\n";
$storagePath = realpath(__DIR__ . '/../storage');
$publicPath = realpath(__DIR__ . '/../storage/app/public');
$profilePhotosPath = realpath(__DIR__ . '/../storage/app/public/profile-photos');

echo "Storage path: " . $storagePath . "\n";
echo "  Exists: " . (is_dir($storagePath) ? 'YES' : 'NO') . "\n";
echo "  Writable: " . (is_writable($storagePath) ? 'YES' : 'NO') . "\n\n";

echo "Public storage path: " . $publicPath . "\n";
echo "  Exists: " . (is_dir($publicPath) ? 'YES' : 'NO') . "\n";
echo "  Writable: " . (is_writable($publicPath) ? 'YES' : 'NO') . "\n\n";

echo "Profile photos path: " . ($profilePhotosPath ?: $publicPath . '/profile-photos') . "\n";
echo "  Exists: " . (is_dir($profilePhotosPath) ? 'YES' : 'NO') . "\n";
if (is_dir($profilePhotosPath)) {
    echo "  Writable: " . (is_writable($profilePhotosPath) ? 'YES' : 'NO') . "\n";
}

// Check symbolic link
$publicStorageLink = realpath(__DIR__ . '/storage');
echo "\nPublic storage symlink: " . ($publicStorageLink ?: __DIR__ . '/storage') . "\n";
echo "  Exists: " . (file_exists(__DIR__ . '/storage') ? 'YES' : 'NO') . "\n";
echo "  Is link: " . (is_link(__DIR__ . '/storage') ? 'YES' : 'NO') . "\n";

echo "</pre>";

// Simple upload test form
?>
<hr>
<h3>Simple Upload Test</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="test_file" required>
    <button type="submit">Test Upload</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    echo "<h4>Upload Test Results:</h4>";
    echo "<pre>";
    print_r($_FILES);
    
    if ($_FILES['test_file']['error'] === UPLOAD_ERR_OK) {
        echo "\nUpload successful!\n";
        echo "Temp file: " . $_FILES['test_file']['tmp_name'] . "\n";
        echo "File exists: " . (file_exists($_FILES['test_file']['tmp_name']) ? 'YES' : 'NO') . "\n";
        echo "File size: " . filesize($_FILES['test_file']['tmp_name']) . " bytes\n";
    } else {
        echo "\nUpload failed with error code: " . $_FILES['test_file']['error'] . "\n";
    }
    echo "</pre>";
}
?>
