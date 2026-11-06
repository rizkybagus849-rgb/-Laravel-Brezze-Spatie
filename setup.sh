#!/usr/bin/env bash
# Setup otomatis (Linux / macOS / Git Bash). Jalankan: bash setup.sh
set -e
ROOT="$(cd "$(dirname "$0")" && pwd)"
APP="$ROOT/buku-app"

echo "==> 1. Membuat proyek Laravel 11"
composer create-project laravel/laravel:^11.0 "$APP" --prefer-dist
cd "$APP"

echo "==> 2. Memasang Laravel Breeze (Blade)"
composer require laravel/breeze:^2.0 --dev
php artisan breeze:install blade --no-interaction

echo "==> 3. Memasang Spatie Laravel Permission v6"
composer require spatie/laravel-permission:^6.0
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force

echo "==> 4. Menyalin file aplikasi (overlay)"
cp -R "$ROOT/overlay/." "$APP/"

echo "==> 5. Migration + Seeder"
php artisan optimize:clear
php artisan migrate:fresh --seed --force

echo "==> 6. Build aset frontend"
npm install
npm run build

echo "SELESAI. Buka di VS Code: code \"$APP\""
