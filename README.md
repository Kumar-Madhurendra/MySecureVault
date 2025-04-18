# Laravel Project with MongoDB

This is a Laravel project that uses MongoDB as its database and is configured for deployment on Render.

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 16 and npm
- MongoDB
- Git

## Local Development Setup

1. **Clone the repository**
```bash
git clone <your-repository-url>
cd <project-directory>
```

2. **Install PHP Dependencies**
```bash
composer install
```

3. **Install Node.js Dependencies**
```bash
npm install
```

4. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure MongoDB**
Update your `.env` file with your MongoDB connection:
```
DB_CONNECTION=mongodb
MONGODB_URI=your_mongodb_connection_string
```

6. **Set up the application**
```bash
php artisan storage:link
php artisan migrate
```

7. **Start the Development Server**

In one terminal:
```bash
php artisan serve
```

In another terminal:
```bash
npm run dev
```

The application will be available at `http://localhost:8000`

## Deployment on Render

### Prerequisites
1. A Render account
2. A MongoDB database (can be hosted on MongoDB Atlas)
3. Your project pushed to a Git repository

### Deployment Steps

1. **Create a New Web Service on Render**
   - Sign in to your Render account
   - Click "New +" and select "Web Service"
   - Connect your repository
   - Choose "PHP" as the environment

2. **Configure Environment Variables**
   Set the following environment variables in Render dashboard:
   - `APP_KEY`: Generate using `php artisan key:generate --show`
   - `MONGODB_URI`: Your MongoDB connection string
   - Other variables as needed from your `.env` file

3. **Deploy**
   - Render will automatically deploy your application using the configuration in `render.yaml`
   - The build process is defined in `render-build.sh`

### Files for Render Deployment

The repository includes two important files for Render deployment:

1. `render.yaml`: Defines the service configuration
2. `render-build.sh`: Contains the build and setup commands

## Project Structure

```
├── app/                 # Application core code
├── bootstrap/          # App bootstrap and autoloading
├── config/            # Configuration files
├── database/         # Database migrations and seeders
├── public/          # Publicly accessible files
├── resources/      # Views, raw assets, and translations
├── routes/        # Application routes
├── storage/      # Logs, cache, and generated files
├── tests/       # Test files
└── vendor/     # Composer dependencies
```

## Available Commands

```bash
# Start development server
php artisan serve

# Run Vite development server
npm run dev

# Build assets for production
npm run build

# Run migrations
php artisan migrate

# Clear cache
php artisan cache:clear

# Create a new controller
php artisan make:controller ControllerName

# Create a new model
php artisan make:model ModelName
```

## Dependencies

### PHP Dependencies
- Laravel Framework 12.0
- Laravel Sanctum 4.0
- Laravel Tinker 2.10.1
- Laravel UI 4.6
- MongoDB Laravel MongoDB 5.0

### Node.js Dependencies
- Vite
- TailwindCSS
- Bootstrap
- Axios
- Laravel Vite Plugin

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the GitHub repository or contact the maintainers.

## Security

If you discover any security-related issues, please email the maintainers instead of using the issue tracker.
