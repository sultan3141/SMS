@echo off
set PHP_PATH=C:\xampp\php\php.exe

echo ========================================
echo Fix Database and Run System
echo ========================================
echo.

echo Killing any existing PHP processes...
taskkill /F /IM php.exe >nul 2>&1

echo Wiping and refreshing database...
%PHP_PATH% artisan migrate:fresh --seed
if %errorlevel% neq 0 (
    echo Migration failed!
    pause
    exit /b %errorlevel%
)

echo.
echo ========================================
echo Starting Server
echo ========================================
echo.
echo Teacher Dashboard: http://localhost:8000/teacher
echo Admin Dashboard: http://localhost:8000/admin
echo.
echo Demo Teacher Login:
echo   Email: teacher@school.com
echo   Password: password
echo.

%PHP_PATH% -S localhost:8000 server.php
