# Menggunakan base image PHP 8.2 versi CLI (sangat ringan)
FROM php:8.2-cli

# Install dependensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mariadb-client

# Install ekstensi PHP untuk koneksi MySQL
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy Composer dari image resminya
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory ke /app
WORKDIR /app

# Copy seluruh kode Laravel ke dalam container
COPY . /app

# Expose port untuk artisan serve
EXPOSE 8000

# Script otomatis saat container berjalan: 
# Install vendor, jalankan migrasi database, lalu hidupkan server
CMD composer install && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000