@echo off
echo Creating storage link for Laravel...

cd /d "C:\laragon\www\ikasmadapangkep"

REM Remove existing link/file if exists
if exist "public\storage" (
    echo Removing existing storage link/file...
    rmdir "public\storage" 2>nul
    del "public\storage" 2>nul
)

REM Create junction (for Windows)
mklink /J "public\storage" "storage\app\public"

if %errorlevel% == 0 (
    echo Storage link created successfully!
) else (
    echo Failed to create storage link. Please run this script as Administrator.
)

pause
