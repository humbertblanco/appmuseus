# Deployment Guide

## Server Requirements
- PHP 8.2+ with extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, PDO_MySQL (or PDO_SQLite), Tokenizer, XML, GD
- MySQL 8.0 / MariaDB 10.6+ (or SQLite for development)
- Composer 2.x
- Node.js 18+ (only needed to compile assets)

## Quick Deploy (Plesk / cPanel / VPS)

### 1. Upload files
```bash
git clone https://github.com/humbertblanco/appmuseus /var/www/vhosts/YOUR_DOMAIN/httpdocs
```

### 2. Set Document Root
Point your web server's document root to the `public/` directory.

### 3. Create Database
Create a MySQL database and note the credentials.

### 4. Configure the Application
```bash
cd /var/www/vhosts/YOUR_DOMAIN/httpdocs

# Copy configuration
cp .env.example .env

# Edit .env with your settings:
# APP_NAME="Your Museum Name"
# APP_URL=https://your-domain.com
# DB_CONNECTION=mysql
# DB_DATABASE=your_database
# DB_USERNAME=your_user
# DB_PASSWORD=your_password
# MUSEUM_NAME="Your Museum Audioguide"
# MUSEUM_INSTITUTION="Your Institution"

# Install dependencies
composer install --optimize-autoloader --no-dev

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed sample data (optional)
php artisan db:seed

# Create storage symlink
php artisan storage:link

# Compile frontend assets
npm install && npm run build

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 775 storage bootstrap/cache
```

### 5. Create Admin User
```bash
php artisan tinker
```
```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@your-domain.com',
    'password' => bcrypt('your_secure_password'),
    'role' => 'super_admin'
]);
```

### 6. Enable SSL
Use Let's Encrypt or your preferred SSL provider.

## Key URLs
- **Frontend**: https://your-domain.com/
- **Admin Panel**: https://your-domain.com/admin

## Maintenance
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# View logs
tail -f storage/logs/laravel.log
```

## Backup
```bash
# Database
mysqldump -u user -p database > backup.sql

# Uploaded files
tar -czf backup-storage.tar.gz storage/app/public
```
