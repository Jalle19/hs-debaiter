FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_mysql \
    zip

# Configure Caddy to use HTTP only
ENV SERVER_NAME=:80

COPY . /app

# Install Composer and dependencies
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install

# Add our extra Caddy definitions to the end
RUN cat Caddyfile.extra >> /etc/caddy/Caddyfile
