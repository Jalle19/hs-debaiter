#
# Build the frontend
#
FROM node:22 AS frontend

WORKDIR /app
COPY webui /app

RUN npm install

RUN npm run build

#
# Build the app server
#
FROM dunglas/frankenphp:1.2-php8.3-bookworm

RUN install-php-extensions \
    pdo_mysql \
    zip

# Configure Caddy to use HTTP only
ENV SERVER_NAME=:80

COPY . /app

# Install Composer and dependencies
COPY --from=composer:2.7 /usr/bin/composer /usr/local/bin/composer
RUN composer install

# Copy frontend to /webui
COPY --from=frontend /app/build /webui

# Add our extra Caddy definitions to the end
RUN cat Caddyfile.extra >> /etc/caddy/Caddyfile
