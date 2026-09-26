#!/bin/sh
set -e

PORT="${PORT:-80}"

sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/:80>/:${PORT}>/" /etc/apache2/sites-available/*.conf

php artisan config:clear
php artisan storage:link || true
php artisan migrate --force || true

exec apache2-foreground