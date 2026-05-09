@echo off
setlocal enabledelayedexpansion

REM ======================================
REM AI ATTENDANCE - AUTO RUN SCRIPT
REM Automatically checks and sets up everything
REM before running face recognition
REM ======================================

REM Get paths
set "SCRIPT_DIR=%~dp0"
set "PROJECT_ROOT=%SCRIPT_DIR%"
cd /d "%PROJECT_ROOT%"
cd ..
set "PROJECT_ROOT=%cd%"

set "ENV_PATH=%PROJECT_ROOT%\face_attendance_env"
set "PYTHON_EXE=%ENV_PATH%\Scripts\python.exe"
set "REGISTER_SCRIPT=%SCRIPT_DIR%face_engine\deep_learning\register_face.py"
set "SETUP_SCRIPT=%SCRIPT_DIR%setup.bat"
set "STUDENT_ID=%1"

REM ======================================
REM CHECK 1: Validate required files exist
REM ======================================
if not exist "%REGISTER_SCRIPT%" (
    echo ERROR: Face recognition script not found
    echo Path: %REGISTER_SCRIPT%
    
    exit /b 1
)

REM ======================================
REM CHECK 2: Check if Python virtual environment exists
REM ======================================
if not exist "%PYTHON_EXE%" (
    echo [INFO] Virtual environment not found - initializing setup...
    echo.
    call "%SETUP_SCRIPT%"
    if errorlevel 1 (
        echo ERROR: Setup failed. Please install Python 3.8+
        
        exit /b 1
    )
)

REM ======================================
REM CHECK 3: Verify critical packages are installed
REM ======================================
echo Verifying dependencies...

REM Quick check using Python
"%PYTHON_EXE%" -c "import cv2, numpy, tensorflow, mtcnn" 2>nul
if errorlevel 1 (
    echo [WARNING] Some packages missing - installing...
    call "%SETUP_SCRIPT%"
)

echo.

REM ======================================
REM CHECK 4: Validate student ID provided
REM ======================================
if "%STUDENT_ID%"=="" (
    echo ERROR: Student ID not provided
    echo Usage: run_attendance.bat [STUDENT_ID]
    
    exit /b 1
)

REM ======================================
REM EXECUTE: Run face recognition
REM ======================================
echo ======================================
echo Starting Face Recognition...
echo Student ID: %STUDENT_ID%
echo ======================================
echo.

REM Run Python script with error handling
"%PYTHON_EXE%" "%REGISTER_SCRIPT%" "%STUDENT_ID%"

REM Check if Python execution was successful
if errorlevel 1 (
    echo.
    echo ERROR: Face recognition script failed
    echo This could mean:
    echo - Camera not connected
    echo - Face detection failed
    echo - Missing dependencies
    echo.
    echo Trying auto-repair setup...
    call "%SETUP_SCRIPT%"
    echo.
    
    exit /b 1
)

echo.
echo ======================================
echo Face Recognition Completed Successfully
echo ======================================
exit /b 0

