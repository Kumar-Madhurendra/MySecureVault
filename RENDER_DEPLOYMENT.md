# Render Deployment Guide

This document provides instructions for deploying the application on Render.com and fixing common issues.

## Fix UI Display Issues

If your UI is not displaying properly on Render (CSS/JS not loading), follow these steps:

1. **Update Environment Variables**:
   - Set `APP_URL` to your Render URL (e.g., `https://mysecurevault.onrender.com`)
   - Add `ASSET_URL=${APP_URL}` to ensure assets load from the correct domain

2. **Run the Asset Fix Script**:
   ```bash
   ./render-fix-assets.sh
   ```
   This script will:
   - Configure proper URL settings
   - Set up file-based session and cache storage
   - Create necessary directories with correct permissions
   - Rebuild assets with the correct URL configuration
   - Clear and regenerate Laravel caches

## Manual Deployment Steps

If you prefer to manually fix the issues:

1. **Edit `.env` file**:
   ```
   APP_URL=https://your-render-app-url.onrender.com
   ASSET_URL=${APP_URL}
   SESSION_DRIVER=file
   CACHE_STORE=file
   ```

2. **Rebuild assets**:
   ```bash
   npm install
   npm run build
   ```

3. **Clear and cache Laravel configuration**:
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

## Common Issues and Solutions

### 1. Missing Assets (CSS/JS not loading)
- Ensure `APP_URL` and `ASSET_URL` are correctly set
- Verify the `public/build` directory exists and has the correct permissions
- Check that Vite has successfully built the assets

### 2. 500 Server Errors
- Switch to file-based session and cache storage
- Ensure storage directories have proper write permissions
- Check Laravel logs for specific error messages

### 3. Blank Pages
- Enable debug mode temporarily (`APP_DEBUG=true`)
- Check web server logs
- Verify PHP extensions are properly installed

## Debugging

If you're still experiencing issues, try these debugging steps:

1. **Check Laravel logs**:
   ```bash
   tail -n 100 storage/logs/laravel.log
   ```

2. **Verify file permissions**:
   ```bash
   ls -la storage
   ls -la bootstrap/cache
   ls -la public/build
   ```

3. **Test asset loading**:
   Create a simple HTML file in the public directory to test static file serving. 