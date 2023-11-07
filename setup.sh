#!/bin/sh

echo "Creating .env file..."
if [ ! -f .env ]; then
    cp .env.example .env
else
    echo ".env file already exists, skipping..."
fi

# Install Sail
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
