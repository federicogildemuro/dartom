# Use an official PHP image with FPM (FastCGI Process Manager) for PHP 8.2
FROM php:8.2-fpm

# Install dependencies required for Laravel (like GD, Composer, bcmath, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory inside the container
WORKDIR /var/www

# Copy the Laravel project files into the container
COPY . .

# Run Composer to install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 so Laravel's server can be accessed
EXPOSE 9000

# Command to run the Laravel development server inside the container
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "9000"]
