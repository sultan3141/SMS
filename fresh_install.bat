@echo off
set PHP_PATH=C:\xampp\php\php.exe

echo ========================================
echo PERFORMING CLEAN INSTALL
echo ========================================
echo.
echo 1. Removing old configuration...
if exist "composer.lock" del "composer.lock"
if exist "vendor" rmdir /s /q "vendor"

echo.
echo 2. Installing dependencies (Fresh)...
%PHP_PATH% composer.phar install --no-interaction --prefer-dist

echo.
echo 3. Generating Application Key...
%PHP_PATH% artisan key:generate --force

echo.
echo 4. Restarting Application...
cmd /c "run_teacher_app.bat"
