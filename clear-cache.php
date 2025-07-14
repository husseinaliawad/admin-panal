<?php
/**
 * Cache Clear Script
 * Upload this file to your public_html directory and run it via browser
 * URL: https://completitcompservice.de/clear-cache.php
 */

echo "<h2>🧹 CICS Cache Clear Script</h2>";
echo "<style>body{font-family:Arial;margin:40px;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";

// Check if we're in the right directory
if (!file_exists('artisan')) {
    echo "<p class='error'>❌ Error: artisan file not found. Make sure this script is in the Laravel root directory.</p>";
    exit;
}

echo "<p class='info'>📁 Current directory: " . getcwd() . "</p>";

// Clear different types of cache
$commands = [
    'Config Cache' => 'php artisan config:clear',
    'Route Cache' => 'php artisan route:clear', 
    'View Cache' => 'php artisan view:clear',
    'Application Cache' => 'php artisan cache:clear',
];

echo "<h3>🧹 Clearing Cache:</h3>";

foreach ($commands as $name => $command) {
    echo "<p class='info'>Running: $command</p>";
    
    $output = [];
    $returnCode = 0;
    
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "<p class='success'>✅ $name cleared successfully</p>";
    } else {
        echo "<p class='error'>❌ Failed to clear $name</p>";
        echo "<p class='info'>Output: " . implode('<br>', $output) . "</p>";
    }
}

// Recreate cache for production
echo "<h3>⚡ Recreating Cache:</h3>";

$cacheCommands = [
    'Config Cache' => 'php artisan config:cache',
    'Route Cache' => 'php artisan route:cache',
    'View Cache' => 'php artisan view:cache',
];

foreach ($cacheCommands as $name => $command) {
    echo "<p class='info'>Running: $command</p>";
    
    $output = [];
    $returnCode = 0;
    
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "<p class='success'>✅ $name created successfully</p>";
    } else {
        echo "<p class='error'>❌ Failed to create $name</p>";
        echo "<p class='info'>Output: " . implode('<br>', $output) . "</p>";
    }
}

echo "<hr>";
echo "<p class='success'>🎉 Cache operations completed!</p>";
echo "<p class='info'>🎯 <strong>Next Steps:</strong></p>";
echo "<p>1. Test your website: <a href='/' target='_blank'>https://completitcompservice.de</a></p>";
echo "<p>2. Check if the changes are reflected</p>";
echo "<p>3. <strong>Delete this script file after use for security!</strong></p>";
?> 