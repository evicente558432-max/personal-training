FROM php:8.2-apache

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

RUN a2enmod rewrite

RUN sed -i 's/Listen 80/Listen 10000/g' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/g' /etc/apache2/sites-available/000-default.conf

RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN cp .env.example .env
RUN sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/g' .env
RUN sed -i 's/SESSION_DRIVER=database/SESSION_DRIVER=file/g' .env
RUN sed -i 's/CACHE_STORE=database/CACHE_DRIVER=file/g' .env

RUN sed -i '/^DB_HOST/d' .env && echo "" >> .env && echo "DB_HOST=byjoduqjgfhd0lrwcdol-mysql.services.clever-cloud.com" >> .env
RUN sed -i '/^DB_PORT/d' .env && echo "DB_PORT=3306" >> .env
RUN sed -i '/^DB_DATABASE/d' .env && echo "DB_DATABASE=byjoduqjgfhd0lrwcdol" >> .env
RUN sed -i '/^DB_USERNAME/d' .env && echo "DB_USERNAME=uzyamed5cgx3bjvw" >> .env
RUN sed -i '/^DB_PASSWORD/d' .env && echo "DB_PASSWORD=J8kAfGJWcpALiRQjjCzO" >> .env

RUN php artisan key:generate
RUN php artisan config:cache

RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 10000
CMD ["/bin/bash", "/start.sh"]