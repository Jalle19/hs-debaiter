FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_mysql

# Use HTTP only
ENV SERVER_NAME=:80

COPY . /app

# Add our extra definitions to the end
RUN cat Caddyfile.extra >> /etc/caddy/Caddyfile
