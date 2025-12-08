FROM node:25-alpine3.23

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
    php85 \
    php85-bcmath \
    php85-ctype \
    php85-curl \
    php85-dom \
    php85-fileinfo \
    php85-fpm \
    php85-gd \
    php85-iconv \
    php85-intl \
    php85-json \
    php85-mbstring \
    php85-openssl \
    php85-pdo \
    php85-pdo_mysql \
    php85-phar \
    php85-session \
    php85-tokenizer \
    php85-xml \
    php85-xmlreader \
    php85-xmlwriter \
    php85-zip \
    supervisor

# Add a non-root user to prevent files being created with root permissions on host machine
RUN addgroup -g 1001 laravel \
    && adduser -u 1001 -G laravel -s /bin/ash -D laravel \
    && chown laravel:laravel /usr/sbin/crond \
    && setcap cap_setgid=ep /usr/sbin/crond

# Configure nginx
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY .docker/fpm-pool.conf /etc/php85/php-fpm.d/www.conf
COPY .docker/php.ini /etc/php85/conf.d/custom.ini

# Configure supervisord
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Configure cron
COPY .docker/crontab /etc/crontabs

RUN chown -R laravel /etc/crontabs/laravel
RUN chmod -R 644 /etc/crontabs/laravel

# Make sure files/folders needed by the processes are accessable when they run under the laravel user
RUN chown -R laravel:laravel /var/www/html /run /var/lib/nginx /var/log/nginx

# Create symlink for php
RUN ln -s /usr/bin/php85 /usr/bin/php

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
RUN npm prune --omit=dev && \
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
