@echo off
setlocal enabledelayedexpansion

REM ======================================
REM AI ATTENDANCE - AUTO SETUP SCRIPT
REM Automatically installs everything needed
REM ======================================

echo ======================================
echo AI Attendance System - Auto Setup
echo ======================================
echo.

REM Get project root
cd /d %~dp0
cd ..
set "PROJECT_ROOT=%cd%"
set "ENV_PATH=%PROJECT_ROOT%\face_attendance_env"
set "REQUIREMENTS=%PROJECT_ROOT%\AI_Attendance\requirements.txt"

echo Project Root: %PROJECT_ROOT%
echo.

REM ======================================
REM STEP 1: Check if Python is installed globally
REM ======================================
echo Checking Python installation...
python --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Python not found in system PATH
    echo Please install Python 3.8+ from python.org
    
    exit /b 1
)
python --version
echo.

REM ======================================
REM STEP 2: Check and create virtual environment
REM ======================================
if exist "%ENV_PATH%\Scripts\python.exe" (
    echo [OK] Virtual environment found at: %ENV_PATH%
) else (
    echo [INFO] Creating virtual environment...
    python -m venv "%ENV_PATH%"
    if errorlevel 1 (
        echo ERROR: Failed to create virtual environment
        
        exit /b 1
    )
    echo [OK] Virtual environment created successfully
)
echo.

REM ======================================
REM STEP 3: Activate virtual environment
REM ======================================
echo Activating virtual environment...
call "%ENV_PATH%\Scripts\activate.bat"
if errorlevel 1 (
    echo ERROR: Failed to activate virtual environment
    
    exit /b 1
)
echo [OK] Virtual environment activated
echo.

REM ======================================
REM STEP 4: Upgrade pip to latest version
REM ======================================
echo Upgrading pip...
python -m pip install --upgrade pip --quiet
if errorlevel 1 (
    echo WARNING: pip upgrade had issues, continuing anyway...
)
echo [OK] pip upgraded
echo.

REM ======================================
REM STEP 5: Install required packages
REM ======================================
if not exist "%REQUIREMENTS%" (
    echo ERROR: requirements.txt not found at: %REQUIREMENTS%
    
    exit /b 1
)

echo Installing dependencies from requirements.txt...
echo This may take a few minutes on first run...
echo.

REM Install with output
pip install -r "%REQUIREMENTS%"
if errorlevel 1 (
    echo WARNING: Some packages may have failed, but continuing...
)
echo.

REM ======================================
REM STEP 6: Verify critical packages
REM ======================================
echo Verifying critical packages...

REM Check OpenCV
python -c "import cv2; print('[OK] OpenCV:', cv2.__version__)" 2>nul
if errorlevel 1 echo WARNING: OpenCV not found - installing...

REM Check numpy
python -c "import numpy; print('[OK] NumPy:', numpy.__version__)" 2>nul
if errorlevel 1 echo WARNING: NumPy not found - installing...

REM Check other critical libs
python -c "import tensorflow; print('[OK] TensorFlow installed')" 2>nul
if errorlevel 1 echo WARNING: TensorFlow not found - this may be needed

echo.

echo [INFO] Python setup complete. Skipping Composer setup.
exit /b 0

REM ======================================
REM STEP 7: Install Composer dependencies
REM ======================================
echo Checking PHP...
php --version >nul 2>&1
if errorlevel 1 (
    echo [INFO] PHP not found. Installing via winget...
    winget install --id=PHP.PHP.8.2 -e
    if errorlevel 1 (
        echo ERROR: PHP install failed. Please install PHP 8.2+ manually.
        
        exit /b 1
    )
)

REM Refresh PATH for current session (after winget install)
for /f "usebackq delims=" %%P in (`powershell -NoProfile -Command "[System.Environment]::GetEnvironmentVariable('Path','Machine') + ';' + [System.Environment]::GetEnvironmentVariable('Path','User')"`) do set "PATH=%%P"

echo Checking Composer...
composer --version >nul 2>&1
if errorlevel 1 (
    echo [INFO] Composer not found. Installing...
    powershell -NoProfile -ExecutionPolicy Bypass -Command "$installer = Join-Path $env:TEMP 'Composer-Setup.exe'; Invoke-WebRequest https://getcomposer.org/Composer-Setup.exe -OutFile $installer; Start-Process $installer -ArgumentList '/SILENT' -Wait"
    if errorlevel 1 (
        echo ERROR: Composer install failed. Please install Composer manually.
        
        exit /b 1
    )
)

if exist "%PROJECT_ROOT%\composer.json" (
    echo Installing PHP dependencies (composer install)...
    pushd "%PROJECT_ROOT%"
    composer install
    if errorlevel 1 (
        echo WARNING: Composer install had issues, please check manually.
    )
    popd
) else (
    echo [INFO] composer.json not found at project root. Skipping Composer install.
)
echo.

REM ======================================
REM STEP 8: Install PHPMailer 
REM ======================================
set "PHPMAILER_DIR=%PROJECT_ROOT%\php\third_party\phpmailer"
if exist "%PHPMAILER_DIR%\src\PHPMailer.php" (
    echo [OK] PHPMailer already installed.
) else (
    echo Installing PHPMailer...
    powershell -NoProfile -ExecutionPolicy Bypass -Command "$zip = Join-Path $env:TEMP 'phpmailer.zip'; Invoke-WebRequest -Uri 'https://github.com/PHPMailer/PHPMailer/archive/refs/tags/v6.9.1.zip' -OutFile $zip; $dest = Join-Path $env:TEMP 'phpmailer_unpack'; if (Test-Path $dest) { Remove-Item -Recurse -Force $dest }; Expand-Archive -Path $zip -DestinationPath $dest; $src = Join-Path $dest 'PHPMailer-6.9.1\src'; New-Item -ItemType Directory -Force -Path '%PHPMAILER_DIR%\src' | Out-Null; Copy-Item -Recurse -Force $src\* '%PHPMAILER_DIR%\src'"
    if errorlevel 1 (
        echo WARNING: PHPMailer install failed.
    ) else (
        echo [OK] PHPMailer installed
    )
)
echo.

REM ======================================
REM STEP 9: Success message
REM ======================================
echo ======================================
echo Setup completed successfully!
echo ======================================
echo.
echo Virtual Environment: %ENV_PATH%
echo Python Executable: %ENV_PATH%\Scripts\python.exe
echo.
echo You can now use run_attendance.bat to scan faces
echo The system will auto-activate everything when needed
echo.

exit /b 0

