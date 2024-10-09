FROM docker.io/php:8-cli
WORKDIR /app/
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
    && rm -rf /var/lib/apt/lists/*
RUN curl 'https://getcomposer.org/download/2.8.1/composer.phar' \
        -o /usr/local/bin/composer \
    && chmod 0755 /usr/local/bin/composer
COPY composer.json composer.lock artisan .
RUN composer update --no-scripts
COPY . .
CMD ["./artisan", "serve", "--host=0"]
