#!/bin/sh

# Start crond in the background
/usr/sbin/crond -b

# Let supervisord start nginx & php-fpm
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
