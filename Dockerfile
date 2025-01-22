FROM node:23-alpine3.21

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
    php84 \
    php84-bcmath \
    php84-ctype \
    php84-curl \
    php84-dom \
    php84-fileinfo \
    php84-fpm \
    php84-gd \
    php84-intl \
    php84-json \
    php84-mbstring \
    php84-opcache \
    php84-openssl \
    php84-pdo \
    php84-pdo_mysql \
    php84-phar \
    php84-session \
    php84-tokenizer \
    php84-xml \
    php84-xmlreader \
    php84-xmlwriter \
    php84-zip \
    supervisor

# Add a non-root user to prevent files being created with root permissions on host machine
RUN addgroup -g 1001 laravel \
    && adduser -u 1001 -G laravel -s /bin/ash -D laravel \
    && chown laravel:laravel /usr/sbin/crond \
    && setcap cap_setgid=ep /usr/sbin/crond

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY .docker/fpm-pool.conf /etc/php84/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php84/conf.d/custom.ini

# Configure supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure cron
COPY .docker/crontab /etc/crontabs

RUN chown -R laravel /etc/crontabs/laravel
RUN chmod -R 644 /etc/crontabs/laravel

# Make sure files/folders needed by the processes are accessable when they run under the laravel user
RUN chown -R laravel:laravel /var/www/html /run /var/lib/nginx /var/log/nginx

# Create symlink for php
RUN ln -s /usr/bin/php84 /usr/bin/php

# Add application
COPY --chown=laravel . /var/www/html/

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install to install the dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Run npm install to satisfy build requirements
RUN npm ci

# Build app
RUN npm run build

# Remove dev-only dependencies & clear cache
RUN npm ci --production && \
    npm cache clean --force

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
