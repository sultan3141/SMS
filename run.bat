@echo off
set PHP_PATH=C:\xampp\php\php.exe

echo ========================================
echo SMS System - Full Setup and Run
echo ========================================
echo.

REM Check if vendor folder exists
if not exist "vendor" (
    echo Installing Composer dependencies...
    echo This may take a few minutes...
    %PHP_PATH% -r "readfile('https://getcomposer.org/installer');" | %PHP_PATH%
    %PHP_PATH% composer.phar install --no-dev --optimize-autoloader
)

echo Generating application key...
%PHP_PATH% artisan key:generate --force

echo Running database migrations...
%PHP_PATH% artisan migrate --force

echo Seeding demo teacher data...
%PHP_PATH% artisan db:seed --class=TeacherDemoSeeder --force

echo Creating storage link...
%PHP_PATH% artisan storage:link

echo.
echo ========================================
echo Starting Development Server
echo ========================================
echo.
echo Teacher Dashboard: http://localhost:8000/teacher
echo Admin Dashboard: http://localhost:8000/admin
echo.
echo Demo Teacher Login:
echo   Email: teacher@school.com
echo   Password: password
echo.
echo Press Ctrl+C to stop the server
echo.

%PHP_PATH% artisan serve
