#!/bin/sh
set -e

PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Setup storage symlink
php artisan storage:link || true

# Run database migrations
if [ "$RUN_MIGRATIONS" != "false" ]; then
    echo "==> Menjalankan database migrations..."
    php artisan migrate --force || echo "==> Migrasi dilewati/sudah termigrasi."
fi

# Run database seeder jika diaktifkan
if [ "$SEED_DATABASE" = "true" ]; then
    echo "==> Mengisi data awal (seeder)..."
    php artisan db:seed --force || echo "==> Seeder selesai/sudah ada data."
fi

# Cache production
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "==> Menjalankan Apache pada port ${PORT}..."
exec apache2-foreground

