@echo off
echo ===================================================
echo AI ATTENDANCE LAUNCHER
echo ===================================================
echo.
echo [INFO] This script runs the website as YOU (not as a service).
echo [INFO] This allows the Face Recognition window to be visible.
echo.
echo [IMPORTANT] Please keep XAMPP MySQL (Database) RUNNING.
echo [IMPORTANT] Please STOP XAMPP Apache.
echo.
echo Starting web server at http://localhost:8000 ...
echo.
echo Press Ctrl+C to stop.
echo.

cd /d "%~dp0"
php -S localhost:8000 -t .

pause
