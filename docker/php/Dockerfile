FROM php:7.3.9-fpm-alpine

LABEL maintainer="Alejandro Sosa <alesjohnson@hotmail.com>"

RUN apk add --update --no-cache \
    coreutils \
    php7-fpm \
    php7-apcu \
    php7-ctype \
    php7-curl \
    php7-dom \
    php7-gd \
    php7-iconv \
    php7-imagick \
    php7-json \
    php7-intl \
    php7-mcrypt \
    php7-fileinfo\
    php7-mbstring \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-pdo_mysql \
    php7-mysqli \
    php7-xml \
    php7-zlib \
    php7-phar \
    php7-tokenizer \
    php7-session \
    php7-simplexml \
    php7-xdebug \
    php7-zip \
    php7-xmlwriter \
    make \
    curl \
    git \
    icu-dev \
    libxml2-dev \
    libzip-dev \
    g++ \
    autoconf

RUN apk update \
    && apk add  --no-cache \
    && docker-php-source extract \
    && pecl install xdebug \
    && pecl install redis \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && docker-php-ext-install soap intl zip \
    && docker-php-ext-enable redis \
    && rm -rf /tmp/*

RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY default.ini /etc/php7/conf.d/
COPY default.ini /etc/php7/cli/conf.d/
COPY xdebug.ini  /etc/php7/conf.d/
COPY default.pool.conf /etc/php7/php-fpm.d/


WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm7", "-F"]
