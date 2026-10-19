#!/usr/bin/env bash
set -euo pipefail
[ -f .env ] || cp .env.example .env
composer install
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
printf '\nReady. Run: php artisan serve\nAdmin: http://127.0.0.1:8000/admin/login\n'
