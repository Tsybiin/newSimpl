FROM php:8.2-fpm
RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
WORKDIR /usr/share/nginx/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl  'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN useradd -ms /bin/bash old_cont
RUN usermod -u 1000 old_cont \
  && groupmod -g 1000 old_cont
RUN apt-get install sudo -y
RUN usermod -aG sudo old_cont && rm /etc/localtime && ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
USER old_cont


