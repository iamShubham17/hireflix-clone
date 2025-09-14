FROM php:8.2.29-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    zip \
    unzip \
    nginx \
    && docker-php-ext-install pdo_pgsql pgsql bcmath pcntl \
    && echo "extension=pdo_pgsql.so" >> /usr/local/etc/php/conf.d/docker-php-ext-pdo_pgsql.ini \
    && echo "extension=pgsql.so" >> /usr/local/etc/php/conf.d/docker-php-ext-pgsql.ini \
    && php -m | grep -E 'pdo_pgsql|pgsql' || { echo "PostgreSQL extensions not loaded"; exit 1; }

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY . .

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Nginx config for Laravel (proxy to PHP-FPM)
COPY <<EOF /etc/nginx/sites-available/default
server {
    listen 10000;  # Render scans on 10000 by default
    server_name localhost;
    root /var/www/html/public;
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param HTTPS on;  # For Render's proxy
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Expose port for Render
EXPOSE 10000

# Start PHP-FPM and Nginx
CMD service nginx start && php-fpm
