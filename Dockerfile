FROM node:22.0.0-alpine3.19

# Set the application variables
ENV APP_NAME=Leaderboard

# Setup document root
WORKDIR /var/www/html

# Install packages and remove default server definition
RUN apk add --no-cache \
    dcron \
    libcap \
    curl \
    nodejs-current \
    npm \
    nginx \
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

# Add a non-root user to prevent files being created with root permissions on host machine
RUN addgroup -g 1001 laravel \
    && adduser -u 1001 -G laravel -s /bin/ash -D laravel \
    && chown laravel:laravel /usr/sbin/crond \
    && setcap cap_setgid=ep /usr/sbin/crond

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY .docker/fpm-pool.conf /etc/php83/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php83/conf.d/custom.ini

# Configure supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure cron
COPY .docker/crontab /etc/crontabs

RUN chown -R laravel /etc/crontabs/laravel
RUN chmod -R 644 /etc/crontabs/laravel

# Make sure files/folders needed by the processes are accessable when they run under the laravel user
RUN chown -R laravel.laravel /var/www/html /run /var/lib/nginx /var/log/nginx

# Create symlink for php
RUN ln -s /usr/bin/php83 /usr/bin/php

# Add application
COPY --chown=laravel . /var/www/html/

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install to install the dependencies
RUN composer install --optimize-autoloader --no-interaction --no-progress

# Run npm install to install node dependencies
RUN npm install

# Build app
RUN npm run build

# Set entrypoint execution permission
RUN chmod +x .docker/entrypoint.sh

# Switch to non-root user
USER laravel

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
ENTRYPOINT [".docker/entrypoint.sh"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping || exit 1
