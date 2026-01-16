@echo off
set PHP_PATH=C:\xampp\php\php.exe

echo ========================================
echo Regenerating Autoload Files
echo ========================================
echo.
%PHP_PATH% composer.phar dump-autoload -o

echo.
echo ========================================
echo Restarting Application
echo ========================================
echo.
cmd /c "run_teacher_app.bat"
