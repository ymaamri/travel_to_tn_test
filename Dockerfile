FROM serversideup/php:8.2-fpm-nginx

# Copy application code
COPY --chown=www-data:www-data . /var/www/html

# Ensure storage and cache directories have write permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
