<?php
/**
 * Storage Link Fix Script
 * Upload this file to your public_html directory and run it via browser
 * URL: https://completitcompservice.de/fix-storage-link.php
 */

echo "<h2>🔧 CICS Storage Link Fix Script</h2>";
echo "<style>body{font-family:Arial;margin:40px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Check if we're in the right directory
if (!file_exists('artisan')) {
    echo "<p class='error'>❌ Error: artisan file not found. Make sure this script is in the Laravel root directory.</p>";
    exit;
}

echo "<p class='info'>📁 Current directory: " . getcwd() . "</p>";

// Check storage directory
$storageDir = __DIR__ . '/storage/app/public';
if (!is_dir($storageDir)) {
    echo "<p class='error'>❌ Storage directory not found: $storageDir</p>";
} else {
    echo "<p class='success'>✅ Storage directory exists: $storageDir</p>";
}

// Check public/storage link
$publicStorageLink = __DIR__ . '/public/storage';
if (is_link($publicStorageLink)) {
    echo "<p class='success'>✅ Storage link already exists</p>";
    echo "<p class='info'>🔗 Link points to: " . readlink($publicStorageLink) . "</p>";
} else {
    echo "<p class='error'>❌ Storage link does not exist</p>";
    
    // Try to create the link
    $targetPath = '../storage/app/public';
    
    if (symlink($targetPath, $publicStorageLink)) {
        echo "<p class='success'>✅ Storage link created successfully!</p>";
    } else {
        echo "<p class='error'>❌ Failed to create storage link</p>";
        echo "<p class='info'>📝 Manual steps:</p>";
        echo "<p>1. Delete public/storage if it exists as a folder</p>";
        echo "<p>2. Create symbolic link: ln -s ../storage/app/public public/storage</p>";
    }
}

// Check brand images
$brandsDir = __DIR__ . '/storage/app/public/brands';
if (is_dir($brandsDir)) {
    $files = scandir($brandsDir);
    $imageFiles = array_filter($files, function($file) {
        return !in_array($file, ['.', '..', '.gitignore']);
    });
    
    echo "<p class='success'>✅ Brands directory exists with " . count($imageFiles) . " files:</p>";
    echo "<ul>";
    foreach ($imageFiles as $file) {
        echo "<li>$file</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='error'>❌ Brands directory not found</p>";
}

// Test image URLs
echo "<h3>🖼️ Testing Image URLs:</h3>";
$testImages = [
    'Logo' => '/images-/logo.jpg',
    'Apple Brand' => '/storage/brands/apple.jpg',
    'Samsung Brand' => '/storage/brands/samsung.jpg',
];

foreach ($testImages as $name => $url) {
    $fullPath = __DIR__ . '/public' . $url;
    if (file_exists($fullPath)) {
        echo "<p class='success'>✅ $name: <a href='$url' target='_blank'>$url</a></p>";
    } else {
        echo "<p class='error'>❌ $name: $url (File not found)</p>";
    }
}

// Set permissions
echo "<h3>🔒 Setting Permissions:</h3>";
$dirs = [
    'storage' => 0775,
    'bootstrap/cache' => 0775,
    'storage/app/public' => 0775,
    'storage/app/public/brands' => 0775,
];

foreach ($dirs as $dir => $perm) {
    $fullPath = __DIR__ . '/' . $dir;
    if (is_dir($fullPath)) {
        if (chmod($fullPath, $perm)) {
            echo "<p class='success'>✅ Set permissions for $dir</p>";
        } else {
            echo "<p class='error'>❌ Failed to set permissions for $dir</p>";
        }
    } else {
        echo "<p class='error'>❌ Directory not found: $dir</p>";
    }
}

echo "<hr>";
echo "<p class='info'>🎯 <strong>Next Steps:</strong></p>";
echo "<p>1. Test your website: <a href='/' target='_blank'>https://completitcompservice.de</a></p>";
echo "<p>2. Check brand images are loading in the 'Browse Popular Brands' section</p>";
echo "<p>3. If issues persist, check the server error logs</p>";
echo "<p>4. <strong>Delete this script file after use for security!</strong></p>";
?> 