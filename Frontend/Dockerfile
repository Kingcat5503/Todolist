# Use latest PHP with Apache (correct image tag)
FROM php:apache

WORKDIR /var/www/html

# Install dependencies including SQLite3
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache mod_rewrite (for clean URLs)
RUN a2enmod rewrite

# Copy frontend files into container
COPY . /var/www/html

# Expose HTTP port
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
