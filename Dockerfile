FROM alpine:3.19

# Setup document root
WORKDIR /var/www/html

# Install packages and remove default server definition
RUN apk add --no-cache \
    curl \
    nginx \
    npm \
    php83 \
    php83-bcmath \
    php83-ctype \
    php83-curl \
    php83-dom \
    php83-fileinfo \
    php83-fpm \
    php83-gd \
    php83-intl \
    php83-json \
    php83-mbstring \
    php83-opcache \
    php83-openssl \
    php83-pdo \
    php83-pdo_mysql \
    php83-phar \
    php83-session \
    php83-tokenizer \
    php83-xml \
    php83-xmlreader \
    php83-xmlwriter \
    php83-zip \
    supervisor

# Create symlink so programs depending on `php` still function
RUN ln -s /usr/bin/php83 /usr/bin/php

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY .docker/fpm-pool.conf /etc/php83/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php83/conf.d/custom.ini

# Configure supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html /run /var/lib/nginx /var/log/nginx

# Switch to use a non-root user from here on
USER nobody

# Add application
COPY --chown=nobody . /var/www/html/

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install to install the dependencies
RUN composer install --optimize-autoloader --no-interaction --no-progress

# Clear npm cache
RUN chown -R 65534:65534 /.npm

# Run npm install to install node dependencies
RUN npm install

# Build
RUN npm run build

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping || exit 1
