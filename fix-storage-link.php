<?php

// Script untuk memperbaiki storage link di Windows

$publicStoragePath = __DIR__ . '/public/storage';
$targetPath = __DIR__ . '/storage/app/public';

// Hapus link/file lama jika ada
if (file_exists($publicStoragePath)) {
    if (is_link($publicStoragePath)) {
        unlink($publicStoragePath);
        echo "Removed existing symlink.\n";
    } elseif (is_file($publicStoragePath)) {
        unlink($publicStoragePath);
        echo "Removed existing file.\n";
    } elseif (is_dir($publicStoragePath)) {
        rmdir($publicStoragePath);
        echo "Removed existing directory.\n";
    }
}

// Untuk Windows, gunakan mklink /J (junction)
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Convert paths to Windows format
    $publicStoragePathWin = str_replace('/', '\\', $publicStoragePath);
    $targetPathWin = str_replace('/', '\\', $targetPath);
    
    // Create junction using mklink
    $command = 'mklink /J "' . $publicStoragePathWin . '" "' . $targetPathWin . '"';
    
    echo "Running command: $command\n";
    
    $output = [];
    $returnVar = 0;
    exec($command, $output, $returnVar);
    
    if ($returnVar === 0) {
        echo "Junction created successfully!\n";
        echo implode("\n", $output) . "\n";
    } else {
        echo "Failed to create junction. Return code: $returnVar\n";
        echo "Output: " . implode("\n", $output) . "\n";
        
        // Try alternative method
        echo "\nTrying alternative method...\n";
        if (@symlink($targetPath, $publicStoragePath)) {
            echo "Symlink created successfully using PHP symlink function!\n";
        } else {
            echo "Failed to create symlink using PHP function.\n";
        }
    }
} else {
    // For Unix-like systems
    if (@symlink($targetPath, $publicStoragePath)) {
        echo "Symlink created successfully!\n";
    } else {
        echo "Failed to create symlink.\n";
    }
}

// Verify the link
if (is_link($publicStoragePath) || is_dir($publicStoragePath)) {
    echo "\nVerification: Storage link exists and points to: " . readlink($publicStoragePath) . "\n";
    
    // Test creating a file
    $testFile = $targetPath . '/test.txt';
    file_put_contents($testFile, 'Test file');
    
    if (file_exists($publicStoragePath . '/test.txt')) {
        echo "Test passed: Files are accessible through the link.\n";
        unlink($testFile);
    } else {
        echo "Warning: Files may not be accessible through the link.\n";
    }
} else {
    echo "\nError: Storage link was not created.\n";
}
