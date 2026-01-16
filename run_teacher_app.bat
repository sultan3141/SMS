@echo off
set PHP_PATH=C:\xampp\php\php.exe

echo ========================================
echo SMS System - Teacher Dashboard Setup
echo ========================================
echo.

echo 1. Generating Application Key...
%PHP_PATH% artisan key:generate --force

echo 2. Running Database Migrations...
%PHP_PATH% artisan migrate --force

echo 3. Seeding Database...
%PHP_PATH% artisan db:seed --class=TeacherDemoSeeder --force

echo 4. Linking Storage...
%PHP_PATH% artisan storage:link

echo.
echo ========================================
echo SETUP COMPLETE
echo ========================================
echo.
echo Starting Server...
echo Teacher Login: teacher@school.com / password
echo.
%PHP_PATH% -S localhost:8000 server.php
