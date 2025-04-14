# Use the official PHP 8.2 image with FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Install dependencies required for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory inside the container
WORKDIR /var/www

# Copy the Laravel project files into the container
COPY . .

# Install PHP dependencies without dev packages and optimize autoload
RUN composer install --no-dev --optimize-autoloader

# Generate the storage link for public access to storage
RUN php artisan storage:link

# Expose port 9000 for Laravel's development server
EXPOSE 9000

# Run Laravel's built-in development server
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "9000"]
