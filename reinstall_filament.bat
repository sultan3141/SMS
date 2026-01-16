@echo off
set PHP_PATH=C:\xampp\php\php.exe

echo ========================================
echo Reinstalling Filament Packages
echo ========================================
echo.
echo Deleting vendor/filament...
rmdir /s /q "vendor\filament"

echo.
echo Installing dependencies...
%PHP_PATH% composer.phar install --ignore-platform-reqs

echo.
echo Regenerating Autoload...
%PHP_PATH% composer.phar dump-autoload -o

echo.
echo ========================================
echo Restarting Application
echo ========================================
echo.
cmd /c "run_teacher_app.bat"
