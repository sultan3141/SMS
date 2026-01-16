<?php
// Manual asset copying script
echo "Copying Filament assets manually...\n\n";

function recursiveCopy($src, $dst) {
    $dir = opendir($src);
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    $count = 0;
    while(($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcPath = $src . '/' . $file;
            $dstPath = $dst . '/' . $file;
            
            if (is_dir($srcPath)) {
                $count += recursiveCopy($srcPath, $dstPath);
            } else {
                copy($srcPath, $dstPath);
                $count++;
            }
        }
    }
    closedir($dir);
    return $count;
}

// Copy Filament assets
$filamentSrc = __DIR__ . '/vendor/filament/filament/dist';
$filamentDst = __DIR__ . '/public';

if (is_dir($filamentSrc)) {
    echo "Copying from: {$filamentSrc}\n";
    echo "To: {$filamentDst}\n\n";
    
    $count = recursiveCopy($filamentSrc, $filamentDst);
    echo "✓ Copied {$count} Filament files\n";
} else {
    echo "✗ Source directory not found: {$filamentSrc}\n";
}

echo "\nDone!\n";
