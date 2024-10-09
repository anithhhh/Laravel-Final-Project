FROM docker.io/php:8-cli
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
    && rm -rf /var/lib/apt/lists/*
RUN curl https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
COPY composer.json composer.lock artisan .
RUN composer update --no-scripts
COPY . .
CMD ["./artisan", "serve", "--host=0"]
