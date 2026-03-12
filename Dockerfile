# Use official PHP image with Apache
FROM php:8.2-apache

# Enable mysqli (or pdo_mysql) for database
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your project files to the web server root
COPY . /var/www/html/

# Expose port 8080 (Render default for web services)
EXPOSE 8080
