FROM php:8.0-cli
RUN apt-get update -y && apt-get install -y \
    git \
    libzip-dev \
    unzip \
    libicu-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN docker-php-ext-install zip \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& docker-php-ext-install opcache

WORKDIR /app

CMD bash -c "composer install && symfony server:start --port=3160"
