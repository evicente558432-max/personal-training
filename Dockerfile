FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Change Apache port to 10000
RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

# Set Laravel public as document root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Allow .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy env
RUN cp .env.example .env
RUN sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/g' .env
RUN sed -i 's/SESSION_DRIVER=database/SESSION_DRIVER=file/g' .env
RUN sed -i 's/CACHE_STORE=database/CACHE_DRIVER=file/g' .env

# Generate key
RUN php artisan key:generate

# Cache config
RUN php artisan config:cache

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Startup script to migrate and start apache
RUN echo '#!/bin/bash\nphp artisan migrate --force\napache2-foreground' > /start.sh
RUN chmod +x /start.sh

EXPOSE 10000
CMD ["/bin/bash", "/start.sh"]