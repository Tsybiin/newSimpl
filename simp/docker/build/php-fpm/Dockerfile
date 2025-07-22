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
#RUN  apt install symfony-cli
#
#RUN apt-get update && apt-get install -y \
#        curl \
#        libfreetype6-dev \
#        libjpeg62-turbo-dev \
#        libmcrypt-dev \
#        libpng-dev \
#        msmtp \
#        nano\
#       sendmail\
#        gettext \
#        wget \
#        mc  \
#    software-properties-common \
#        npm\
#        screen && \
#        rm -r /var/lib/apt/lists/*
#RUN docker-php-ext-configure gd --with-freetype --with-jpeg
#RUN docker-php-ext-install gd
#RUN docker-php-ext-install sockets
#RUN docker-php-ext-install pdo_mysql
#RUN docker-php-ext-install mysqli

#WORKDIR /var/www/
#RUN usermod -u 1000 www-data
#
#RUN curl -sS https://getcomposer.org/installer | php -- \
#--install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer



#RUN curl -sS https://getcomposer.org/installer | php -- \
#        --filename=composer \
#        --install-dir=/usr/local/bin && \
#        echo "alias composer='composer'" >> /root/.bashrc && \
#        composer

#  Install APCu and APC backward compatibility
# RUN pecl install channel://pecl.php.net/APCu-5.1.21 \
#     && pecl install apcu_bc-1.0.3 \
#     && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
#     && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini
#
#RUN npm install npm@latest -g && \
#    npm install n -g && \
#    n latest

#RUN pecl install xdebug-3.1.6 \
#    && docker-php-ext-enable xdebug
#ADD php.ini /usr/local/etc/php/conf.d/php.ini

ADD fake_sendmail.sh /usr/bin/fake_sendmail.sh

RUN chmod -R 777 /usr/bin/fake_sendmail.sh
RUN chmod -R 777  /var/mail


