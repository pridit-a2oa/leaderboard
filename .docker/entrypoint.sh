#!/bin/sh

# Start crond in the background
crond -l 2 -b

# Let supervisord start nginx & php-fpm
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
