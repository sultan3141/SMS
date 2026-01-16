@echo off
echo ========================================
echo Running Database Migrations
echo ========================================
echo.
php artisan migrate
echo.
echo ========================================
echo Seeding Demo Teacher Data
echo ========================================
echo.
php artisan db:seed --class=TeacherDemoSeeder
echo.
echo Done! Demo teacher: teacher@school.com / password
pause
