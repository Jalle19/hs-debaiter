FROM dunglas/frankenphp:1.3-php8.4-bookworm

LABEL org.opencontainers.image.source="https://github.com/Jalle19/hs-debaiter"
LABEL org.opencontainers.image.licenses="GPL-2.0-only"
LABEL org.opencontainers.image.authors="Sam Stenvall <neggelandia@gmail.com>"

RUN install-php-extensions \
    pdo_mysql \
    zip

# Configure Caddy to use HTTP only
ENV SERVER_NAME=:80

COPY .. /app

# Install Composer and dependencies
COPY --from=composer:2.8 /usr/bin/composer /usr/local/bin/composer
RUN composer install

EXPOSE 80