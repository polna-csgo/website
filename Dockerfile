# Use a lightweight PHP image with Apache
FROM php:8.2-apache

# Install PHP extensions (for MySQL database support)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the project files into the web directory
COPY . /var/www/html

# Set correct ownership
RUN chown -R www-data:www-data /var/www/html

# Enable Apache mod_rewrite (useful for future URL routing)
RUN a2enmod rewrite

# Expose default HTTP port
EXPOSE 80
