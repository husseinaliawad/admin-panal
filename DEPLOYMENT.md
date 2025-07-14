# Laravel Production Deployment Guide

## Issue: Images Not Loading on Production Server

The images are not displaying because the Laravel storage symbolic link needs to be created on the production server.

## Quick Fix (Do this on your hosting server):

### Option 1: Using Terminal/SSH
If you have SSH access to your hosting server:

```bash
# Navigate to your project directory
cd /home/u102530462/domains/completitcompservice.de/public_html

# Create the storage symbolic link
php artisan storage:link

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Option 2: Using cPanel File Manager
If you're using cPanel/Hostinger File Manager:

1. **Log into your hosting control panel**
2. **Open File Manager** and navigate to your domain folder
3. **Open Terminal** (if available) or use the file manager
4. **Run this command** in the terminal:
   ```bash
   php artisan storage:link
   ```

### Option 3: Manual Symbolic Link Creation
If you can't run artisan commands:

1. **Navigate to**: `/home/u102530462/domains/completitcompservice.de/public_html/public/`
2. **Create a folder** called `storage`
3. **Point this folder** to: `../storage/app/public/`

## Complete Deployment Steps:

### 1. Update .env File
Create/update your `.env` file on the production server:

```env
APP_NAME="CICS Computer & Services"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://completitcompservice.de

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password

FILAMENT_DOMAIN=completitcompservice.de
```

### 2. Run Deployment Commands
```bash
# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. File Permissions
Make sure these folders have proper permissions:
- `storage/` - 775
- `bootstrap/cache/` - 775
- `public/storage/` - should be a symbolic link

## Expected File Structure:
```
public_html/
├── public/
│   ├── storage/ → ../storage/app/public/ (symbolic link)
│   ├── build/ (your compiled assets)
│   └── images-/ (your static images)
├── storage/
│   └── app/
│       └── public/
│           ├── brands/
│           ├── categories/
│           └── products/
└── .env
```

## Testing:
After deployment, test these URLs:
- `https://completitcompservice.de/` - Main site
- `https://completitcompservice.de/storage/brands/filename.jpg` - Image access
- `https://completitcompservice.de/admin` - Admin panel

## Common Issues:
1. **Storage link not created** - Run `php artisan storage:link`
2. **Wrong permissions** - Set 775 on storage folders
3. **Missing .env** - Copy and configure .env file
4. **Cache issues** - Clear all caches with artisan commands

## Support:
If images are still not loading, check:
1. File permissions on storage folders
2. .env APP_URL matches your domain
3. Database connection is working
4. Storage symbolic link exists in public folder 