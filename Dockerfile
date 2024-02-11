FROM php:cli

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pgsql

WORKDIR /app

COPY index.php .
