FROM php:8.1-fpm

# Install nginx
RUN apt-get update && apt-get install -y nginx supervisor

# Copy PHP app
COPY . /var/www/html/

# Copy nginx config
COPY default.conf /etc/nginx/sites-available/default

# Configure Supervisor
COPY --from=php:8.1-fpm /usr/local/etc/php-fpm.d/www.conf /etc/php/8.1/fpm/pool.d/www.conf
RUN echo '[supervisord]\nnodaemon=true\n\n[program:php-fpm]\ncommand=/usr/local/sbin/php-fpm\n\n[program:nginx]\ncommand=/usr/sbin/nginx -g "daemon off;"' > /etc/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
