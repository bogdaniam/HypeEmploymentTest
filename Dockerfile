# Dockerfile for PHP Web Server
FROM php:8.2-apache

# Install mysqli extension for PHP (if needed, PDO is preferred)
# Install pdo_mysql extension for PHP
RUN docker-php-ext-install pdo_mysql

# Install MySQL client for command-line access
RUN apt-get update && apt-get install -y default-mysql-client

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files to the web server's document root
COPY ./src /var/www/html/

# Set appropriate permissions for the web server
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (default for Apache)
EXPOSE 80
