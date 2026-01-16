@echo off
echo ========================================
echo Laravel SMS System - Setup Script
echo ========================================
echo.

echo [1/4] Generating Application Key...
php artisan key:generate
echo.

echo [2/4] Installing Composer Dependencies...
composer install --no-interaction
echo.

echo [3/4] Installing NPM Dependencies...
call npm install
echo.

echo [4/4] Running Database Migrations...
php artisan migrate --force
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo To create an admin user, run:
echo php artisan make:filament-user
echo.
echo To start the server, run: serve.bat
echo.
pause
