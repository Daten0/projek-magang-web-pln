Docker setup for projek-magang-web-pln

Quick start (from project root `projek-magang-web-pln`):

1. Copy `.env.example` to `.env` and adjust DB values if desired. Ensure these DB config match `docker-compose.yml`:

   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=laravel
   DB_PASSWORD=secret

2. Build and run containers:

```bash
docker compose up --build -d
```

3. Open app in browser: http://localhost:8080
   phpMyAdmin: http://localhost:8081 (user: root, password: root)

4. To view logs or run artisan commands:

```bash
docker compose exec app bash
php artisan migrate
php artisan tinker
```

Notes:
- The entrypoint attempts to run `composer install` and `php artisan migrate` on container start. If you prefer to run them manually, exec into the `app` container and run the commands.
- If you already have a database running on host port 3306, you may change mapping in `docker-compose.yml` or stop the host DB.
