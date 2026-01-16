<?php
// Complete asset publishing script
echo "Publishing all Filament assets to public directory...\n\n";

function recursiveCopy($src, $dst) {
    if (!is_dir($src)) {
        echo "✗ Source not found: {$src}\n";
        return 0;
    }
    
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

// 1. Copy Filament core assets to /css/filament/filament/ and /js/filament/filament/
echo "1. Copying Filament CSS assets...\n";
$cssSrc = __DIR__ . '/vendor/filament/filament/dist/theme.css';
$cssDst = __DIR__ . '/public/css/filament/filament/app.css';
if (is_file($cssSrc)) {
    @mkdir(dirname($cssDst), 0755, true);
    copy($cssSrc, $cssDst);
    echo "   ✓ Copied theme.css as app.css (" . filesize($cssSrc) . " bytes)\n";
}

echo "\n2. Copying Filament JS assets...\n";
$jsSrc = __DIR__ . '/vendor/filament/filament/dist/index.js';
$jsDst = __DIR__ . '/public/js/filament/filament/app.js';
if (is_file($jsSrc)) {
    @mkdir(dirname($jsDst), 0755, true);
    copy($jsSrc, $jsDst);
    echo "   ✓ Copied index.js as app.js (" . filesize($jsSrc) . " bytes)\n";
}

// Copy echo.js for Livewire
$echoSrc = __DIR__ . '/vendor/filament/filament/dist/echo.js';
$echoDst = __DIR__ . '/public/js/filament/filament/echo.js';
if (is_file($echoSrc)) {
    @mkdir(dirname($echoDst), 0755, true);
    copy($echoSrc, $echoDst);
    echo "   ✓ Copied echo.js (" . filesize($echoSrc) . " bytes)\n";
}

// 3. Copy Livewire assets
echo "\n3. Copying Livewire assets...\n";
$livewireSrc = __DIR__ . '/vendor/livewire/livewire/dist/livewire.js';
$livewireDst = __DIR__ . '/public/vendor/livewire/livewire.js';
if (is_file($livewireSrc)) {
    @mkdir(dirname($livewireDst), 0755, true);
    copy($livewireSrc, $livewireDst);
    echo "   ✓ Copied livewire.js (" . filesize($livewireSrc) . " bytes)\n";
} else {
    echo "   ✗ Livewire source not found at: {$livewireSrc}\n";
    
    // Try alternative path
    $alt = __DIR__ . '/vendor/livewire/livewire/src/dist/livewire.js';
    if (is_file($alt)) {
        copy($alt, $livewireDst);
        echo "   ✓ Copied from alternative path (" . filesize($alt) . " bytes)\n";
    }
}

// 4. Copy Filament support scripts
echo "\n4. Copying Filament support scripts...\n";
$supportScripts = [
    'actions.js',
    'notifications.js',
    'support.js',
];

foreach ($supportScripts as $script) {
    $src = __DIR__ . "/vendor/filament/filament/dist/{$script}";
    $dst = __DIR__ . "/public/js/filament/filament/{$script}";
    if (is_file($src)) {
        copy($src, $dst);
        echo "   ✓ Copied {$script}\n";
    }
}

// 5. Copy fonts
echo "\n5. Copying fonts...\n";
$fontsSrc = __DIR__ . '/vendor/filament/filament/dist/fonts';
$fontsDst = __DIR__ . '/public/fonts';
if (is_dir($fontsSrc)) {
    $count = recursiveCopy($fontsSrc, $fontsDst);
    echo "   ✓ Copied {$count} font files\n";
}

echo "\n✓ Asset publishing complete!\n";
echo "\nCreated structure:\n";
echo "  public/css/filament/filament/app.css\n";
echo "  public/js/filament/filament/app.js\n";
echo "  public/js/filament/filament/echo.js\n";
echo "  public/vendor/livewire/livewire.js\n";
echo "  public/fonts/...\n";
