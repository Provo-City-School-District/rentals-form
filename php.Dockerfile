FROM php:8.4-apache

# Install PDO extension for MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80

# Set permissions for the Apache server
RUN chown -R www-data:www-data /var/www/html/