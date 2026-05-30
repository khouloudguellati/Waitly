#!/bin/sh

echo "=== Starting entrypoint ==="

echo "Testing DB connection..."
php artisan db:show || echo "WARNING: db:show failed"

echo "Running migrations..."
php artisan migrate --force
MIGRATE_EXIT=$?

if [ $MIGRATE_EXIT -ne 0 ]; then
  echo "ERROR: Migration failed with exit code $MIGRATE_EXIT"
  exit 1
fi

echo "Migrations done successfully"

echo "Seeding database..."
php artisan db:seed --force || true

echo "Clearing cache..."
php artisan optimize:clear || true

echo "Starting server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT