# ==========================================================
#  Setup otomatis - Aplikasi Manajemen Buku (Windows / PowerShell)
#  Jalankan dari dalam folder "manajemen-buku" ini:
#      .\setup.ps1
#  Syarat: PHP >= 8.2, Composer, Node.js + npm
# ==========================================================
$ErrorActionPreference = "Stop"
$root = $PSScriptRoot
$app  = Join-Path $root "buku-app"

Write-Host "==> 1. Membuat proyek Laravel 11" -ForegroundColor Cyan
composer create-project laravel/laravel:^11.0 $app --prefer-dist
Set-Location $app

Write-Host "==> 2. Memasang Laravel Breeze (Blade)" -ForegroundColor Cyan
composer require laravel/breeze:^2.0 --dev
php artisan breeze:install blade --no-interaction

Write-Host "==> 3. Memasang Spatie Laravel Permission v6" -ForegroundColor Cyan
composer require spatie/laravel-permission:^6.0
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

Write-Host "==> 4. Menyalin file aplikasi (overlay)" -ForegroundColor Cyan
Copy-Item -Path (Join-Path $root "overlay\*") -Destination $app -Recurse -Force

Write-Host "==> 5. Migration + Seeder" -ForegroundColor Cyan
php artisan optimize:clear
php artisan migrate:fresh --seed --force

Write-Host "==> 6. Build aset frontend" -ForegroundColor Cyan
npm install
npm run build

Write-Host ""
Write-Host "SELESAI. Buka di VS Code:   code `"$app`"" -ForegroundColor Green
Write-Host "Jalankan server:            cd buku-app ; php artisan serve" -ForegroundColor Green
Write-Host "Jalankan pengujian otomatis: php artisan test" -ForegroundColor Green
