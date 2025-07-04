#!/bin/bash

# Start PHP-FPM in background
php-fpm -D

# Check if PHP-FPM started successfully
if [ $? -ne 0 ]; then
    echo "Failed to start PHP-FPM"
    exit 1
fi

# Wait briefly to ensure PHP-FPM is ready
sleep 2

# Start Nginx in foreground (Docker requires a foreground process)
nginx -g "daemon off;"