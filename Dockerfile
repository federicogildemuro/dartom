# Use an official PHP image with FPM (FastCGI Process Manager)
FROM php:8.1-fpm

# Install dependencies required for Laravel (like GD, Composer, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apt-get install -y unzip \
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
