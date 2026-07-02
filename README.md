# Lathian Buat Web - Laravel Project

A modern Laravel web application project ready for development and deployment.

## 🚀 Quick Start

### Prerequisites
- **PHP** 8.1 or higher (tested with 8.2)
- **Composer** - PHP package manager
- **Node.js & npm** (optional, for frontend assets)

### Installation

1. **Navigate to the project**
   ```bash
   cd "c:\xampp\htdocs\lathian buat web"
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Start the development server**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`

## 📁 Project Structure

- **`app/`** - Application core code (Controllers, Models, Services)
- **`routes/`** - Application route definitions
- **`resources/`** - Views, CSS, and JavaScript assets
- **`database/`** - Migrations, factories, and seeders
- **`config/`** - Configuration files for the application
- **`storage/`** - Generated files, logs, and uploads
- **`tests/`** - Feature and unit tests
- **`public/`** - Publicly accessible files and entry point
- **`bootstrap/`** - Framework bootstrap files

## 🔧 Configuration

### Environment Variables
Edit `.env` file to configure:
- `APP_NAME` - Application name
- `APP_ENV` - Environment (local, production)
- `APP_DEBUG` - Debug mode (true/false)
- `APP_URL` - Application URL

### Database Setup
By default, SQLite is configured. To use MySQL:

1. Update `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

2. Run migrations:
   ```bash
   php artisan migrate
   ```

## 📝 Common Commands

### Artisan Commands
```bash
# Create new controller
php artisan make:controller YourController

# Create new model (with migration)
php artisan make:model YourModel -m

# Create new migration
php artisan make:migration create_table_name --create=table_name

# Run all migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Interactive shell
php artisan tinker

# Run tests
php artisan test

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Composer Commands
```bash
# Install dependencies
composer install

# Update dependencies
composer update
```

## 🧪 Testing

Run tests with PHPUnit:
```bash
php artisan test
```

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel API Documentation](https://laravel.com/api)
- [Laracasts - Video Tutorials](https://laracasts.com)

## 📄 License

Open source project. Modify as needed.

---

**Last Updated:** 2026-06-17  
**Laravel Version:** 12.x  
**PHP Version:** 8.1+
