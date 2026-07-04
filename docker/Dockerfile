# FROM php:8.2-apache

# # System deps
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     netcat \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     libzip-dev \
#     && rm -rf /var/lib/apt/lists/*

# # PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# # Enable apache mods
# RUN a2enmod rewrite

# # Install composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Set working dir
# WORKDIR /var/www/html

# # Copy entrypoint
# COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
# RUN chmod +x /usr/local/bin/entrypoint.sh

# ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# EXPOSE 80

# ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
FROM php:8.2-apache

# Install system dependencies (fixed netcat package name)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    netcat-openbsd \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Enable Apache rewrite engine for Laravel routing
RUN a2enmod rewrite

# Copy Composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Update Apache configuration to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy and prepare the entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
