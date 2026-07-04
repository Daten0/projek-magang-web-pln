#!/bin/bash
set -e

# Wait for MySQL to be ready (simple loop)
if [ -n "$DB_HOST" ]; then
  echo "Waiting for database at $DB_HOST:$DB_PORT..."
  until nc -z "$DB_HOST" "$DB_PORT"; do
    sleep 1
  done
fi

cd /var/www/html


# --- ADDED: Force create missing Laravel cache/view folders ---
mkdir -p storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache \
         storage/logs
# -------------------------------------------------------------

# Install composer dependencies if vendor missing
if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate app key if missing
if [ -z "$(php artisan key:generate --show 2>/dev/null || true)" ]; then
  php artisan key:generate || true
fi

# Run migrations (non-interactive)
php artisan migrate --force || true

# Ensure storage permission
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Start Apache in foreground
exec docker-php-entrypoint apache2-foreground
