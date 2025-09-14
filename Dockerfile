FROM php:8.2-apache
# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pdo pdo_mysql
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Copy project files
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# Enable Apache mod_rewrite for Laravel routes
RUN a2enmod rewrite
# Set document root to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Expose port
EXPOSE 8080