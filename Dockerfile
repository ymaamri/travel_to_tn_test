FROM serversideup/php:8.2-fpm-nginx

# Copy the application code first
COPY --chown=www-data:www-data . /var/www/html

# Enter the working directory and run composer install to generate vendor/
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Fix storage and cache permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
