#!/bin/bash

# Laravel Production Deployment Script
# Run this script on your production server after uploading the code

echo "Starting Laravel deployment..."

# Set proper permissions for storage and bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create symbolic link for storage (if not exists)
if [ ! -L "public/storage" ]; then
    php artisan storage:link
    echo "✓ Storage link created"
else
    echo "✓ Storage link already exists"
fi

# Install/Update composer dependencies (production mode)
composer install --optimize-autoloader --no-dev

# Clear and cache config, routes, and views
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Generate application key (if not exists)
php artisan key:generate

# Run database migrations (if needed)
# php artisan migrate --force

# Set final permissions
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

echo "✓ Deployment completed successfully!"
echo ""
echo "Don't forget to:"
echo "1. Update your .env file with production database credentials"
echo "2. Set APP_ENV=production in .env"
echo "3. Set APP_DEBUG=false in .env"
echo "4. Update APP_URL in .env to your domain" 