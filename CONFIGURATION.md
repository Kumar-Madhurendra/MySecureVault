# MySecureVault Configuration Guide

## Session and Cache Configuration

The application is configured to use file-based sessions and cache by default. This configuration offers several advantages:

- **No Database Dependency**: Sessions and cache will work even if the database is unavailable
- **Simpler Setup**: No need to configure database connection just for sessions
- **Better Performance**: File-based sessions can be faster for simple applications

### Important Environment Variables

Make sure your `.env` file includes these settings:

```
SESSION_DRIVER=file
CACHE_STORE=file
```

### MongoDB Configuration

This application uses MongoDB for the media storage functionality. Make sure these variables are properly configured in your `.env` file:

```
MONGO_DB_CONNECTION=mongodb
MONGO_DB_URI=mongodb+srv://username:password@cluster.mongodb.net/database?retryWrites=true&w=majority
MONGO_DB_DATABASE=your_database_name
MONGO_DB_USERNAME=your_username
MONGO_DB_PASSWORD=your_password
MONGO_DB_AUTHENTICATION_DATABASE=admin
```

## Troubleshooting

If you encounter a 500 Server Error after deployment, it might be due to session or cache configuration. Run the provided scripts to fix issues:

1. `php diagnosis.php` - Diagnoses configuration problems
2. `php fix_session_config.php` - Fixes session and cache configuration
3. `./deployment-fix.sh` - Comprehensive fix for deployment issues

## Directory Permissions

Make sure these directories have proper write permissions:

```
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Clearing Cache

After configuration changes, clear all caches:

```
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
``` 