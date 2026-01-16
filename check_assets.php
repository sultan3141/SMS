<?php
// Manually publish Filament assets by copying from vendor to public
// This bypasses the artisan command which is failing

$vendorAssets = __DIR__ . '/vendor/filament';
$publicPath = __DIR__ . '/public';

echo "Checking for Filament vendor assets...\n";

if (!is_dir($vendorAssets)) {
    echo "ERROR: Filament vendor directory not found at: {$vendorAssets}\n";
    echo "Vendor packages may not be installed.\n";
    exit(1);
}

echo "✓ Found Filament in vendor\n";

// Create public directories if they don't exist
$directories = [
    $publicPath . '/css/filament/filament',
    $publicPath . '/js/filament/filament',
    $publicPath . '/vendor/livewire',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✓ Created directory: {$dir}\n";
    }
}

// Search for asset files in vendor
echo "\nSearching for Filament dist assets...\n";

function findFilamentAssets($dir, $pattern) {
    $results = [];
    if (is_dir($dir)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($files as $file) {
            if ($file->isFile() && preg_match($pattern, $file->getPathname())) {
                $results[] = $file->getPathname();
            }
        }
    }
    return $results;
}

$cssFiles = findFilamentAssets($vendorAssets, '/\.css$/');
$jsFiles = findFilamentAssets($vendorAssets, '/\.js$/');

echo "Found " . count($cssFiles) . " CSS files\n";
echo "Found " . count($jsFiles) . " JS files\n";

// List main asset locations
echo "\nChecking vendor structure:\n";
$filamentDirs = glob($vendorAssets . '/*/resources/dist/*');
foreach ($filamentDirs as $dir) {
    echo "  - " . str_replace(__DIR__ . '/vendor/', '', $dir) . "\n";
}

echo "\nTo fix this issue, you need to:\n";
echo "1. Install composer packages properly\n";
echo "2. Run: php artisan filament:assets\n";
echo "   OR\n";
echo "   Manually copy assets from vendor/filament/*/resources/dist/ directories\n";
