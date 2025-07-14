#!/bin/bash

# Server details
SERVER_USER="u102530462"
SERVER_HOST="46.202.156.244"
SERVER_PORT="65002"
SERVER_PATH="/home/u102530462/domains/completitcompservice.de/public_html"

# Local path
LOCAL_PATH="."

echo "🚀 Syncing files to server..."

# Sync files (excluding some directories)
rsync -avz --delete \
  --exclude='node_modules' \
  --exclude='.git' \
  --exclude='vendor' \
  --exclude='storage/logs' \
  --exclude='storage/framework/cache' \
  --exclude='storage/framework/sessions' \
  --exclude='storage/framework/views' \
  -e "ssh -p $SERVER_PORT" \
  $LOCAL_PATH/ $SERVER_USER@$SERVER_HOST:$SERVER_PATH/

echo "📦 Running composer install on server..."
ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "cd $SERVER_PATH && composer install --no-dev --optimize-autoloader"

echo "🧹 Clearing cache on server..."
ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "cd $SERVER_PATH && php artisan config:clear && php artisan route:clear && php artisan view:clear"

echo "⚡ Caching for production..."
ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "cd $SERVER_PATH && php artisan config:cache && php artisan route:cache && php artisan view:cache"

echo "🔗 Creating storage link..."
ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "cd $SERVER_PATH && php artisan storage:link"

echo "🔧 Setting permissions..."
ssh -p $SERVER_PORT $SERVER_USER@$SERVER_HOST "cd $SERVER_PATH && chmod -R 775 storage && chmod -R 775 bootstrap/cache"

echo "✅ Sync complete!" 