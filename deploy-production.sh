#!/bin/bash

# Laravel Production Deployment Script for completitcompservice.de
# Run this script on your production server after uploading the code

echo "🚀 Starting Laravel deployment for completitcompservice.de..."

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: artisan file not found. Make sure you're in the Laravel project directory."
    exit 1
fi

# Set proper permissions for storage and bootstrap/cache
echo "📁 Setting folder permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create directories if they don't exist
mkdir -p storage/app/public/brands
mkdir -p storage/app/public/categories
mkdir -p storage/app/public/products
mkdir -p storage/logs

# Create symbolic link for storage (if not exists)
if [ ! -L "public/storage" ]; then
    php artisan storage:link
    echo "✓ Storage link created"
else
    echo "✓ Storage link already exists"
fi

# Install/Update composer dependencies (production mode)
echo "📦 Installing composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache for production
echo "⚡ Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Generate application key (if not exists)
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Run database migrations (if needed)
read -p "🗃️  Do you want to run database migrations? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
fi

# Set final permissions
echo "🔧 Setting final permissions..."
chown -R $USER:$USER storage
chown -R $USER:$USER bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Test storage link
echo "🔍 Testing storage link..."
if [ -L "public/storage" ]; then
    echo "✅ Storage link is working"
else
    echo "❌ Storage link failed"
fi

echo ""
echo "🎉 Deployment completed successfully!"
echo ""
echo "📋 Final checklist:"
echo "1. ✅ Update your .env file with production database credentials"
echo "2. ✅ Set APP_ENV=production in .env"
echo "3. ✅ Set APP_DEBUG=false in .env"
echo "4. ✅ Update APP_URL=https://completitcompservice.de in .env"
echo "5. ✅ Test the website: https://completitcompservice.de"
echo "6. ✅ Test admin panel: https://completitcompservice.de/admin"
echo ""
echo "🔧 If images are not loading, run: php artisan storage:link" 